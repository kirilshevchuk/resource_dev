<?php
/**
 * Copyright (c) 2009-2010
 * Luke Ehresman - http://luke.ehresman.org
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 */

define("SPREEDLY_VERBOSE", false);

/**
 * Class: Spreedly
 *
 * Provides a convenient wrapper around the spreedly.com API.  Instead
 * of mucking around with HTTP you can just Spreedly::configure and
 * SpreedlySubscriber::find.  Much of the functionality is hung off
 * the SpreedlySubscriber class.
 */
class Spreedly {
	static $token;
	static $site_name;
	static $base_uri;

	/**
	 * Method: configure
	 *
	 * Call this before you start using the API to set things up.
	 */
	public static function configure($site_name, $token) {
		self::$site_name = $site_name;
		self::$token = $token;
		self::$base_uri = "https://spreedly.com/api/v4/$site_name";
	}

	/**
	 * Method: get_edit_subscriber_url
	 *
	 * Generates an edit subscriber for the given subscriber token.  The
	 * token is returned with the subscriber (i.e. by SpreedlySubscriber::find)
	 */
	public static function get_edit_subscriber_url($token) {
		return "https://spreedly.com/".self::$site_name."/subscriber_accounts/$token";
	}

	/**
	 * Method: get_admin_subscriber_url
	 *
	 * Generates a link to the page on your Spreedly profile where you can
	 * administer a user.
	 */
	public static function get_admin_subscriber_url($id) {
		return "https://spreedly.com/".self::$site_name."/subscribers/$id";
	}

	/**
	 * Method: get_subscribe_url
	 *
	 * Generates a subscribe url for the given user id and plan.
	 *
	 * Throws: Exception if the parameters are invalid.
	 *
	 * Parameters:
	 *  $id - the subscriber id
	 *  $plan_id - the spreedly plan id
	 *  $options (optional) - this can be a string (in which case, it is used
	 *     as the screen_name, for legacy purposes), or an array with any of the
	 *     following properties.  All of these are optional:
	 *        "token" => the subscriber's token, provided by spreedly
	 *        "screen_name" => the screen name for this user
	 *        "first_name" => first name to pre-populate into the form
	 *        "last_name" => last name to pre-populate into the form
	 *        "email" => email to pre-populate into the form
	 *        "return_url" => url for the "Continue" button (overrides the site default)
	 *    See the API reference for more details:
	 *      http://spreedly.com/manual/integration-guide/expose-a-subscribe-link/
	 *
	 * Example:
	 *  $url = Spreedly::get_subscribe_url(123, 10, array(
	 *          "return_url"=>"http://www.google.com",
	 *          "email"=>"test@nospam.com",
	 *          "token"=>"XYZ"
	 *      ));
	 */
	public static function get_subscribe_url($id, $plan_id, $options=null) {
		if (!is_integer($plan_id)) {
			//throw new Exception("plan_id must be an integer");
                        return null;
		}

		$url = "https://spreedly.com/".self::$site_name."/subscribers/$id";
		if (is_string($options)) {
			// In this case, $options is a string representing the screen name.
			// For backwards compatibility only.
			// Don't use this except for legacy code.
			$url .= "/subscribe/$plan_id/".rawurlencode($options);
		} else if (is_array($options)) {
			// we have an array of options.
			if (isset($options['token'])) {
				$url .= "/".rawurlencode($options['token']);
				unset($options['token']);
			}
			$url .= "/subscribe/$plan_id";
			if (isset($options['screen_name'])) {
				$url .= "/".rawurlencode($options['screen_name']);
				unset($options['screen_name']);
			}

			$valid_params = array("first_name", "last_name", "email", "return_url");
			$query_values = array();
			foreach ($options as $key=>$value) {
				if (!in_array($key, $valid_params)) return null;
					//throw new Exception("The key '$key' is not valid for Spreedly::get_subscribe_url");
                                        
				$query_values[] = $key."=".rawurlencode($value);
			}
			if (count($query_values)) {
				$url .= "?".implode("&", $query_values);
			}
			return $url;
		} else {
			// in this case, we only have a $id and $plan_id.  This is the base case.
			$url .= "/subscribe/$plan_id";
		}
		return $url;
	}

	/**
	 * Method: get_transactions
	 *
	 * Returns an array of transaction data.  Spreedly returns transactions
	 * in batches of 50 at a time.  So you need to keep calling this, with the
	 * last id as a parameter, until nothing is returned.  See the Spreedly
	 * integration reference for details on how this works:
	 *
	 * https://spreedly.com/manual/integration-reference/show-transactions/
	 */
	public static function get_transactions($since_id=null) {
		$since_param = "";
		if (is_numeric($since_id)) {
			$since_param = "?since_id=$since_id";
		}
		$result = Spreedly::__curl_request("/transactions.xml$since_param", "get");
		$list = Spreedly::__parse_xml($result->response, "transaction", "StdClass");

		// __parse_xml returns an object if there's only one, so turn it back into
		// an array here for consistency.
		if (is_object($list))
			return array($list);
		return $list;
	}

	/**
	 * Method: change_subscription_plan
	 *
	 * Will move a subscriber onto a new plan specified by ID. This call does not 
	 * do any prorating, it doesn't generate an invoice, it doesn't notify your customer, 
	 * it doesn't affect your customer's active_until, and it doesn't charge them anything. 
	 * Your customer's feature level is immediately changed to that of the new plan. 
	 * The next time your customer is renewed, we'll use the details of the new plan to do it.
	 *
	 * Success Returns: stdClass Object ( [response] => Subscription plan successfully changed. [code] => 200 )
	 *
	 * http://spreedly.com/manual/integration-reference/change-subscriber-subscription-plan
	 */
	public static function change_subscription_plan($subscription_id, $subscriber_id) {
		// Build up subscription plan xml
		$obj = new StdClass();
		$obj->subscription_plan = new StdClass();
		$obj->subscription_plan->id = $subscription_id;
		$xml = Spreedly::__to_xml_params($obj);

		// Run the spreedly call
		return Spreedly::__curl_request("/subscribers/$subscriber_id/change_subscription_plan.xml", "put", $xml);
	}

	/**
	 * Method: __curl_request
	 *
	 * Internal method used to make an HTTP request to Spreedly.
	 */
	public static function __curl_request($url, $method="get", $data=null) {
		$ch = curl_init(self::$base_uri.$url);
		if (SPREEDLY_VERBOSE) {
			echo "\n\n\n###############################################\n";
			curl_setopt($ch, CURLOPT_VERBOSE, true);
		}
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERPWD, self::$token.":X");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_TIMEOUT, 8);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				"Content-Type: text/xml",
				"Accept: text/xml"
			));

		switch ($method) {
		case "post":
			if ($data) {
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			} else {
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			}
			break;
		case "delete":
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
			break;
		case "put":
			$fh = fopen("php://memory", "rw");
			fwrite($fh, $data);
			rewind($fh);
			curl_setopt($ch, CURLOPT_INFILE, $fh);
			curl_setopt($ch, CURLOPT_INFILESIZE, strlen($data));
			curl_setopt($ch, CURLOPT_PUT, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					"Content-Type: text/xml",
					"Accept: text/xml",
					"Expect:"
				));
			break;
		default:
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
			break;
		}

		$result = new StdClass();
		$result->response = curl_exec($ch);
		$result->code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		return $result;
	}

	/**
	 * Method: __to_xml_params
	 *
	 * Converts an object structure into XML
	 */
	public static function __to_xml_params($hash, $change=true) {
		$dom = new DOMDocument("1.0");
		$node = self::__create_xml_node($dom, $dom, $hash, $change);
		return $dom->saveXML();
	}
	private static function __create_xml_node($dom, $parentNode, $hash, $change=true) {
		foreach ($hash as $key=>$value) {
			$tag = $key;
			if ($change)
				$tag = str_replace("_", "-", $tag);

			$node = $dom->createElement($tag);
			if (is_object($value)) {
				self::__create_xml_node($dom, $node, $value, $change);
			} else {
				$text = $dom->createTextNode($value);
				$node->appendChild($text);
			}

			$parentNode->appendChild($node);
		}
	}

	/**
	 * Method: __parse_xml
	 *
	 * This will take an XML representation of a subscriber, or a list of
	 * subscribers, and create instances of the SpreedlySubscriber object.
	 * This will return either a single SpreedlySubscriber object, or
	 * an array of SpreedlySubscriber objects.
	 */
	public static function __parse_xml($xml, $node_name, $node_class) {
		if (is_string($xml))
			$dom = @DOMDocument::loadXML($xml);
		else
			$dom = $xml;
		if (!$dom) return null;

		$node_list = $dom->getElementsByTagName($node_name);
		$list = self::__parse_dom_node_list($node_list, $node_class);

		if (count($list) == 0)
			return null;
		else if (count($list) == 1)
			return $list[0];
		else
			return $list;
	}

	/**
	 * Method: __parse_dom_node_list
	 *
	 * This is a helper method for __parse_xml.  It's private, and you should
	 * never need to use it.  Use __parse_xml instead.
	 */
	private static function __parse_dom_node_list($node_list, $node_class) {
		$list = array();
		for ($i=0; $i < $node_list->length; $i++) {
			if ($node_list->item($i) instanceof DOMElement) {
				$list[] = self::__parse_dom_node($node_list->item($i), $node_class);
			}
		}
		return $list;
	}

	/**
	 * Method: __parse_dom_node
	 *
	 * This is a helper method for __parse_xml.  It's private, and you should
	 * never need to use it.  Use __parse_xml instead.
	 */
	private static function __parse_dom_node($node, $node_class) {
		$node = $node->firstChild;
		$obj = new $node_class();
		while ($node) {
			if ($node->nodeType == XML_ELEMENT_NODE) {
				$nodeName = str_replace("-", "_", $node->nodeName);
				if ($node->childNodes->length == 0 || ($node->childNodes->length == 1 && $node->firstChild->childNodes == 0)) {
					if (!is_numeric($node->nodeValue) && $tmp = strtotime($node->nodeValue)) {
						$obj->$nodeName = $tmp;
					} else if ($node->nodeValue == "false") {
						$obj->$nodeName = false;
					} else if ($node->nodeValue == "true") {
						$obj->$nodeName = true;
					} else {
						$obj->$nodeName = $node->nodeValue;
					}
				} else {
					$class = "StdClass";
					if ($nodeName == "subscriber")
						$class = "SpreedlySubscriber";
					if ($node->hasAttribute("type") && $node->getAttribute("type") == "array") {
						$obj->$nodeName = self::__parse_dom_node_list($node->childNodes, $class);
					} else {
						$obj->$nodeName = self::__parse_dom_node($node, $class);
					}
				}
			}
			$node = $node->nextSibling;
		}
		return $obj;
	}
}

/**
 * Class: SpreedlySubscriber
 */
class SpreedlySubscriber {
	/**
	 * Method: activate_free_trial
	 *
	 * Activates a free trial on the subscriber.  Requires subscription_id
	 * of the free trial plan.
	 */
	public function activate_free_trial($subscription_id) {
		$obj = new StdClass();
		$obj->subscription_plan = new StdClass();
		$obj->subscription_plan->id = $subscription_id;
		$xml = Spreedly::__to_xml_params($obj);
		$result = Spreedly::__curl_request("/subscribers/{$this->customer_id}/subscribe_to_free_trial.xml", "post", $xml);

		if (preg_match("/^2..$/", $result->code)) {
			return Spreedly::__parse_xml($result->response, "subscriber", "SpreedlySubscriber");
		} else {
                    return null;
			//throw new SpreedlyException("Could not activate free trial for subscriber: {$result->response} ({$result->code})", $result->code);
		}
	}

	/**
	 * Method: stop_auto_renew
	 *
	 * Turn off automatic renewal of subscriptions in Spreedly.
	 */
	public function stop_auto_renew() {
		$result = Spreedly::__curl_request("/subscribers/{$this->customer_id}/stop_auto_renew.xml", "post");
		if (preg_match("/^2..$/", $result->code)) {
			return true;
                        //return null;
		} else {
                        return null;
			//throw new SpreedlyException("Could not stop auto renew for subscriber: {$result->response} ({$result->code})", $result->code);
		}
	}

	/**
	 * Method: comp
	 *
	 * Allows you to give a complimentary subscription (if the
	 * subscriber is inactive) or a complimentary time extension (if
	 * the subscriber is active).  Automatically figures out which to
	 * do.  Note: units must be one of "days" or "months" (Spreedly
	 * enforced).
	 */
	public function comp($quantity, $units, $feature_level=null) {
		if ($this->lifetime_subscription) {
			return $this;
		}

		$type = $this->active ? "complimentary_time_extensions" : "complimentary_subscriptions";
		if ($type == "complimentary_subscriptions" && !$feature_level) {
                        return null;
			//throw new SpreedlyException("Feature level can't be blank when comping an inactive subscription");
		}

		$node_name = substr($type, 0, -1);
		$obj = new StdClass();
		$obj->$node_name = new StdClass();
		$obj->$node_name->duration_quantity = $quantity;
		$obj->$node_name->duration_units = $units;
		if ($type == "complimentary_subscriptions" && $feature_level) {
			$obj->$node_name->feature_level = $feature_level;
		}

		$xml = Spreedly::__to_xml_params($obj);
		$result = Spreedly::__curl_request("/subscribers/{$this->customer_id}/$type.xml", "post", $xml);

		if (preg_match("/^2..$/", $result->code)) {
			return Spreedly::__parse_xml($result->response, "subscriber", "SpreedlySubscriber");
		} else {
                    return null;
			//throw new SpreedlyException("Could not comp subscriber: {$result->response} ({$result->code})", $result->code);
		}
	}

	/**
	 * Method: update
	 *
	 * Updates a subscriber's details on Spreedly.
	 */
	public function update($email=null, $screen_name=null, $new_customer_id=null) {
		$obj = new StdClass();
		$obj->subscriber = new StdClass();
		if ($email)
			$obj->subscriber->email = $email;
		if ($screen_name)
			$obj->subscriber->screen_name = $screen_name;
		if ($new_customer_id)
			$obj->subscriber->new_customer_id = $new_customer_id;
		$xml = Spreedly::__to_xml_params($obj);
		$result = Spreedly::__curl_request("/subscribers/{$this->get_id()}.xml", "put", $xml);

		if (preg_match("/^2..$/", $result->code)) {
			return Spreedly::__parse_xml($result->response, "subscriber", "SpreedlySubscriber");
		} else if ($result->code == 403) {
                        return null;
			//throw new SpreedlyException("Could not update subscriber: new customer_id already exists.", $result->code);
		} else {
                        return null;
			//throw new SpreedlyException("Could not update subscriber: {$result->response} ({$result->code})", $result->code);
		}
	}

	/**
	 * Method: lifetime_comp
	 *
	 * Adds a complimentary lifetime subscription to the subscriber
	 */
	public function lifetime_comp($feature_level) {
		$obj = new StdClass();
		$obj->lifetime_complimentary_subscription = new StdClass();
		$obj->lifetime_complimentary_subscription->feature_level = $feature_level;
		$xml = Spreedly::__to_xml_params($obj);
		$result = Spreedly::__curl_request("/subscribers/{$this->get_id()}/lifetime_complimentary_subscriptions.xml", "post", $xml);

		if (preg_match("/^2..$/", $result->code)) {
			return Spreedly::__parse_xml($result->response, "subscriber", "SpreedlySubscriber");
		} else {
                    return null;
			//throw new SpreedlyException("Could not add lifetime comp to subscriber: {$result->response} ({$result->code})", $result->code);
		}
	}

	/**
	 * Method: add_store_credit
	 *
	 * Adds store credit to the subscriber
	 */
	public function add_store_credit($amount) {
		$obj = new StdClass();
		$obj->credit = new StdClass();
		$obj->credit->amount = $amount;
		$xml = Spreedly::__to_xml_params($obj);
		$result = Spreedly::__curl_request("/subscribers/{$this->get_id()}/credits.xml", "post", $xml);

		if (preg_match("/^2..$/", $result->code)) {
			return Spreedly::__parse_xml($result->response, "subscriber", "SpreedlySubscriber");
		} else {
                    return null;
			//throw new SpreedlyException("Could not add store credit to subscriber: {$result->response} ({$result->code})", $result->code);
		}
	}

	/**
	 * Method: add_fee
	 *
	 * adds a fee to the subscriber
	 */
	public function add_fee($name, $description, $group, $amount) {
		$obj = new StdClass();
		$obj->fee = new StdClass();
		$obj->fee->name = $name;
		$obj->fee->description = $description;
		$obj->fee->group = $group;
		$obj->fee->amount = $amount;
		$xml = Spreedly::__to_xml_params($obj);
		$result = Spreedly::__curl_request("/subscribers/{$this->get_id()}/fees.xml", "post", $xml);

		if (preg_match("/^2..$/", $result->code)) {
			return Spreedly::__parse_xml($result->response, "subscriber", "SpreedlySubscriber");
		} else {
                    return null;
			//throw new SpreedlyException("Could not add fees to subscriber: {$result->response} ({$result->code})", $result->code);
		}
	}

	/**
	 * Method: allow_free_trial
	 *
	 * allow the subscriber to have another free trial
	 */
	public function allow_free_trial() {
		$result = Spreedly::__curl_request("/subscribers/{$this->customer_id}/allow_free_trial.xml", "post");
		if (preg_match("/^2..$/", $result->code)) {
			return null;
		} else {
                    return null;
			//throw new SpreedlyException("Could not allow free trial for subscriber: {$result->response} ({$result->code})", $result->code);
		}
	}

	/**
	 * Method: get_id
	 *
	 * Spreedly calls your id for the user the "customer id".  This gives
	 * you a handy alias so you can just call it "id".
	 */
	public function get_id() {
		return $this->customer_id;
	}


	/******************************************************************/
	/**  PUBLIC STATIC METHODS                                       **/
	/******************************************************************/

	/**
	 * Method: get_all
	 *
	 * Returns all the subscribers in your site.
	 */
	public static function get_all() {
		$result = Spreedly::__curl_request("/subscribers.xml", "get");
		if (preg_match("/^2..$/", $result->code)) {
			return Spreedly::__parse_xml($result->response, "subscriber", "SpreedlySubscriber");
		} else if ($result->code == 404) {
			return null;
		} else {
                    return null;
			//throw new SpreedlyException("Could not get all subscribers: {$result->response} ({$result->code})", $result->code);
		}
	}

	/**
	 * Method: create
	 *
	 * Creates a new subscriber on Spreedly.  The subscriber will NOT be
	 * active - they have to pay or you have to comp them for that to
	 * happen.
	 */
	public static function create($id, $email=null, $screen_name=null) {
		$obj = new StdClass();
		$obj->subscriber = new StdClass();
		$obj->subscriber->customer_id = $id;
		$obj->subscriber->email = $email;
		$obj->subscriber->screen_name = $screen_name;
		$xml = Spreedly::__to_xml_params($obj);
		$result = Spreedly::__curl_request("/subscribers.xml", "post", $xml);

		if (preg_match("/^2..$/", $result->code)) {
			return Spreedly::__parse_xml($result->response, "subscriber", "SpreedlySubscriber");
		} else if ($result->code == 403) {
                    return null;
			//throw new SpreedlyException("Could not create subscriber: no id passed OR already exists.", $result->code);
		} else {
                    return null;
			//throw new SpreedlyException("Could not create subscriber: {$result->response} ({$result->code})", $result->code);
		}
	}

	/**
	 * Method: delete
	 *
	 * This will DELETE individual subscribers from the site.  Pass in the
	 * customer_id.  Only works for test sites (enforced on the Spreedly
	 * side).
	 */
	public static function delete($id) {
		Spreedly::__curl_request("/subscribers/{$id}.xml", "delete");
	}

	/**
	 * Method: find
	 *
	 * Looks up a subscriber by id.
	 */
	public static function find($id) {
		$result = Spreedly::__curl_request("/subscribers/{$id}.xml", "get");
		if (preg_match("/^2..$/", $result->code)) {
			return Spreedly::__parse_xml($result->response, "subscriber", "SpreedlySubscriber");
		} else if ($result->code == 404) {
			return null;
		} else {
                    return null;
		//	throw new SpreedlyException("Could not find subscriber: {$result->response} ({$result->code})", $result->code);
		}
	}

	/**
	 * Method: wipe
	 *
	 * This will DELETE all the subscribers from the site.  Only works for
	 * test sites (enforced on the Spreedly side).
	 */
	public static function wipe() {
		Spreedly::__curl_request("/subscribers.xml", "delete");
	}
}

/**
 * Class: SpreedlySubscriptionPlan
 */
class SpreedlySubscriptionPlan {
	/**
	 * Method: is_trial
	 *
	 * Convenience method for determining if this plan is a free trial plan
	 * or not.
	 */
	public function is_trial() {
		return $this->plan_type == "free_trial";
	}


	/**
	 * Method: get_all
	 *
	 * Returns all the subscription plans defined in your site.
	 */
	public static function get_all() {
		$result = Spreedly::__curl_request("/subscription_plans.xml", "get");
		if (preg_match("/^2..$/", $result->code)) {
			$list = Spreedly::__parse_xml($result->response, "subscription-plan", "SpreedlySubscriptionPlan");
			if (!is_array($list))
				$list = array($list);
			return $list;
		} else {
                    return array("ErrorCode"=>$result->code,"Response"=>$result->response);
		}
	}

	/**
	 * Method: find
	 *
	 * Returns the subscription plan with the given id.
	 */
	public static function find($id) {
		$all = self::get_all();
		foreach ($all as $plan)
			if ($plan->id == $id)
				return $plan;
		return null;
	}

	/**
	 * Method: find_by_name
	 *
	 * Returns the first subscription plan with the given name.
	 */
	public static function find_by_name($name) {
		$all = self::get_all();
		foreach ($all as $plan)
			if (strtolower($plan->name) == strtolower($name))
				return $plan;
		return null;
	}
}

/**
 * Class: SpreedlyInvoice
 *
 * Invoices are used to create a custom billing interface so users don't
 * have to leave your site to pay through Spreedly.  In general, you first
 * create an invoice, then you pay the invoice using user-provided
 * credentials.
 *
 * NOTE: There are a bunch of special conditions you should consider when
 * displaying an invoice to a user.  Please be sure to read through the
 * Spreedly integration guide before implementing a payment interface:
 * https://spreedly.com/manual/integration-reference/payments-api/displaying-an-invoice/
 */
class SpreedlyInvoice {
	/**
	 * STATIC Method: create
	 *
	 * This will create an invoice for a particular customer.  It ties a
	 * customer with a subscription plan that you've already set in place.
	 *
	 * Example:
	 *   SpreedlyInvoice::create($sub->get_id(), $plan->id, "Bob", "bob@nospam.com");
	 */
	public static function create($customer_id, $subscription_id, $screen_name=null, $email=null) {
		$obj = new StdClass();
		$obj->invoice = new StdClass();
		$obj->invoice->subscription_plan_id = $subscription_id;
		$obj->invoice->subscriber = new StdClass();
		$obj->invoice->subscriber->customer_id = $customer_id;
		$obj->invoice->subscriber->screen_name = $screen_name;
		$obj->invoice->subscriber->email = $email;
		$xml = Spreedly::__to_xml_params($obj);
		$result = Spreedly::__curl_request("/invoices.xml", "post", $xml);

		if (preg_match("/^2..$/", $result->code)) {
			return Spreedly::__parse_xml($result->response, "invoice", "SpreedlyInvoice");
		} else {
                    return null;
			//throw new SpreedlyException("Could not create invoice: {$result->response} ({$result->code})", $result->code);
		}
	}

	/**
	 * Method: pay
	 *
	 * This will pay an existing invoice given the supplied credit card
	 * information.
	 *
	 * NOTE:  This will throw a SpreedlyException if there is a problem
	 * connecting or if there is any unknown issue.  This will return a
	 * SpreedlyErrorList object if there is invalid data that needs to be
	 * verified with the user (e.g. invalid expiration date).  This will return
	 * the updated invoice on success.
	 *
	 * Example:
	 *   $invoice = SpreedlyInvoice::create($sub->get_id(), $plan->id, "Bob", "bob@nospam.com");
	 *   try {
	 *       $result = $invoice->pay($cardno, "visa", "123", "12", "2010", "Bob", "Barker");
	 *       if ($result instanceof SpreedlyErrorList) {
	 *           foreach ($result->get_errors() as $error) {
	 *               echo "<p class=\"error\">$error</p>";
	 *           }
	 *       } else {
	 *           echo "<p class=\"notice\">SUCCESS!</p>";
	 *       }
	 *   } catch (SpreedlyException $e) {
	 *       echo "<p class=\"error\">Unknown error: {$e->getMessage()}!</p>";
	 *   }
	 *
	 */
	public function pay($card_number, $card_type, $verification_value, $month, $year, $first_name, $last_name) {
		$obj = new StdClass();
		$obj->payment = new StdClass();
		$obj->payment->credit_card = new StdClass();
		$obj->payment->credit_card->number = $card_number;
		$obj->payment->credit_card->card_type = $card_type;
		$obj->payment->credit_card->verification_value = $verification_value;
		$obj->payment->credit_card->month = $month;
		$obj->payment->credit_card->year = $year;
		$obj->payment->credit_card->first_name = $first_name;
		$obj->payment->credit_card->last_name = $last_name;
		$xml = Spreedly::__to_xml_params($obj);
		$result = Spreedly::__curl_request("/invoices/{$this->token}/pay.xml", "put", $xml);

		if ($result->code == 404) {
                    return null;
			//throw new SpreedlyException("The specified invoice could not be found.", $result->code);
		} else if ($result->code == 422) {
                    return null;
			//return new SpreedlyErrorList(Spreedly::__parse_xml($result->response, "errors", "StdClass"));
		} else if ($result->code == 504) {
                    return null;
			//throw new SpreedlyException("Gateway timeout.", $result->code);
		} else if (preg_match("/^2..$/", $result->code)) {
			// success!
			return Spreedly::__parse_xml($result->response, "invoice", "SpreedlyInvoice");
		} else {
                    return null;
			//throw new SpreedlyException("Could not pay invoice: {$result->response} ({$result->code})", $result->code);
		}
	}
}


/**
 * Class: SpreedlyException
 */
class SpreedlyException extends Exception {
}

/**
 * Class: SpreedlyErrorList
 */
class SpreedlyErrorList {
	private $errors = array();

	public function __construct($list) {
		if ($list->error)
			$this->errors[] = $list->error;
		else
			$this->errors = $list;
	}

	public function get_errors() {
		return $this->errors;
	}
}
