<?php

declare(strict_types = 1);

namespace PHPTools;

/**
 * Enumeration of HTML codes
 *
 * @version 1.3.0
 * @author 86Dev
 * @link https://en.wikipedia.org/wiki/List_of_HTTP_status_codes
 */
class HtmlCodes extends Enum
{
	/** The server has received the request headers and the client should proceed to send the request body (in the case of a request for which a body needs to be sent; for example, a POST request). Sending a large request body to a server after a request has been rejected for inappropriate headers would be inefficient. To have a server check the request's headers, a client must send Expect: 100-continue as a header in its initial request and receive a 100 Continue status code in response before sending the body. If the client receives an error code such as 403 (Forbidden) or 405 (Method Not Allowed) then it shouldn't send the request's body. The response 417 Expectation Failed indicates that the request should be repeated without the Expect header as it indicates that the server doesn't support expectations (this is the case, for example, of HTTP/1.0 servers). */
	const CONTINUE = 100;

	/** The requester has asked the server to switch protocols and the server has agreed to do so. */
	const SWITCHING_PROTOCOLS = 101;

	/** A WebDAV request may contain many sub-requests involving file operations, requiring a long time to complete the request. This code indicates that the server has received and is processing the request, but no response is available yet. This prevents the client from timing out and assuming the request was lost. */
	const PROCESSING = 102;

	/** Used to return some response headers before final HTTP message. */
	const EARLY_HINTS = 103;

	/** Standard response for successful HTTP requests. The actual response will depend on the request method used. In a GET request, the response will contain an entity corresponding to the requested resource. In a POST request, the response will contain an entity describing or containing the result of the action. */
	const OK = 200;

	/** The request has been fulfilled, resulting in the creation of a new resource. */
	const CREATED = 201;

	/** The request has been accepted for processing, but the processing has not been completed. The request might or might not be eventually acted upon, and may be disallowed when processing occurs. */
	const ACCEPTED = 202;

	/** The server is a transforming proxy (e.g. a Web accelerator) that received a 200 OK from its origin, but is returning a modified version of the origin's response. */
	const NON_AUTHORITATIVE_INFORMATION = 203;

	/** The server successfully processed the request and is not returning any content. */
	const NO_CONTENT = 204;

	/** The server successfully processed the request, but is not returning any content. Unlike a 204 response, this response requires that the requester reset the document view. */
	const RESET_CONTENT = 205;

	/** The server is delivering only part of the resource (byte serving) due to a range header sent by the client. The range header is used by HTTP clients to enable resuming of interrupted downloads, or split a download into multiple simultaneous streams. */
	const PARTIAL_CONTENT = 206;

	/** The message body that follows is by default an XML message and can contain a number of separate response codes, depending on how many sub-requests were made. */
	const MULTI_STATUS = 207;

	/** The members of a DAV binding have already been enumerated in a preceding part of the (multistatus) response, and are not being included again. */
	const ALREADY_REPORTED = 208;

	/** The server has fulfilled a request for the resource, and the response is a representation of the result of one or more instance-manipulations applied to the current instance. */
	const IM_USED = 226;

	/** Indicates multiple options for the resource from which the client may choose (via agent-driven content negotiation). For example, this code could be used to present multiple video format options, to list files with different filename extensions, or to suggest word-sense disambiguation. */
	const MULTIPLE_CHOICES = 300;

	/** This and all future requests should be directed to the given URI. */
	const MOVED_PERMANENTLY = 301;

	/** Tells the client to look at (browse to) another URL. 302 has been superseded by 303 and 307. This is an example of industry practice contradicting the standard. The HTTP/1.0 specification  required the client to perform a temporary redirect (the original describing phrase was "Moved Temporarily"), but popular browsers implemented 302 with the functionality of a 303 See Other. Therefore, HTTP/1.1 added status codes 303 and 307 to distinguish between the two behaviours. However, some Web applications and frameworks use the 302 status code as if it were the 303. */
	const FOUND = 302;

	/** The response to the request can be found under another URI using the GET method. When received in response to a POST (or PUT/DELETE), the client should presume that the server has received the data and should issue a new GET request to the given URI. */
	const SEE_OTHER = 303;

	/** Indicates that the resource has not been modified since the version specified by the request headers If-Modified-Since or If-None-Match. In such case, there is no need to retransmit the resource since the client still has a previously-downloaded copy. */
	const NOT_MODIFIED = 304;

	/** The requested resource is available only through a proxy, the address for which is provided in the response. For security reasons, many HTTP clients (such as Mozilla Firefox and Internet Explorer) do not obey this status code. */
	const USE_PROXY = 305;

	/** No longer used. Originally meant "Subsequent requests should use the specified proxy." */
	const SWITCH_PROXY = 306;

	/** In this case, the request should be repeated with another URI; however, future requests should still use the original URI. In contrast to how 302 was historically implemented, the request method is not allowed to be changed when reissuing the original request. For example, a POST request should be repeated using another POST request. */
	const TEMPORARY_REDIRECT = 307;

	/** The request and all future requests should be repeated using another URI. 307 and 308 parallel the behaviors of 302 and 301, but do not allow the HTTP method to change. So, for example, submitting a form to a permanently redirected resource may continue smoothly. */
	const PERMANENT_REDIRECT = 308;

	/** This class of status code is intended for situations in which the error seems to have been caused by the client. Except when responding to a HEAD request, the server should include an entity containing an explanation of the error situation, and whether it is a temporary or permanent condition. These status codes are applicable to any request method. User agents should display any included entity to the user. */
	const ERROR_ON_WIKIPEDIA = 404;

	/** The server cannot or will not process the request due to an apparent client error (e.g., malformed request syntax, size too large, invalid request message framing, or deceptive request routing). */
	const BAD_REQUEST = 400;

	/** Similar to 403 Forbidden, but specifically for use when authentication is required and has failed or has not yet been provided. The response must include a WWW-Authenticate header field containing a challenge applicable to the requested resource. See Basic access authentication and Digest access authentication. 401 semantically means "unauthorised", the user does not have valid authentication credentials for the target resource. Note: Some sites incorrectly issue HTTP 401 when an IP address is banned from the website (usually the website domain) and that specific address is refused permission to access a website.[citation needed] */
	const UNAUTHORIZED = 401;

	/** Reserved for future use. The original intention was that this code might be used as part of some form of digital cash or micropayment scheme, as proposed, for example, by GNU Taler, but that has not yet happened, and this code is not usually used. Google Developers API uses this status if a particular developer has exceeded the daily limit on requests. Sipgate uses this code if an account does not have sufficient funds to start a call. Shopify uses this code when the store has not paid their fees and is temporarily disabled. Stripe uses this code for failed payments where parameters were correct, for example blocked fraudulent payments. */
	const PAYMENT_REQUIRED = 402;

	/** The request contained valid data and was understood by the server, but the server is refusing action. This may be due to the user not having the necessary permissions for a resource or needing an account of some sort, or attempting a prohibited action (e.g. creating a duplicate record where only one is allowed). This code is also typically used if the request provided authentication via the WWW-Authenticate header field, but the server did not accept that authentication. The request should not be repeated. */
	const FORBIDDEN = 403;

	/** The requested resource could not be found but may be available in the future. Subsequent requests by the client are permissible. */
	const NOT_FOUND = 404;

	/** A request method is not supported for the requested resource; for example, a GET request on a form that requires data to be presented via POST, or a PUT request on a read-only resource. */
	const METHOD_NOT_ALLOWED = 405;

	/** The requested resource is capable of generating only content not acceptable according to the Accept headers sent in the request. See Content negotiation. */
	const NOT_ACCEPTABLE = 406;

	/** The client must first authenticate itself with the proxy. */
	const PROXY_AUTHENTICATION_REQUIRED = 407;

	/** The server timed out waiting for the request. According to HTTP specifications: "The client did not produce a request within the time that the server was prepared to wait. The client MAY repeat the request without modifications at any later time." */
	const REQUEST_TIMEOUT = 408;

	/** Indicates that the request could not be processed because of conflict in the current state of the resource, such as an edit conflict between multiple simultaneous updates. */
	const CONFLICT = 409;

	/** Indicates that the resource requested is no longer available and will not be available again. This should be used when a resource has been intentionally removed and the resource should be purged. Upon receiving a 410 status code, the client should not request the resource in the future. Clients such as search engines should remove the resource from their indices. Most use cases do not require clients and search engines to purge the resource, and a "404 Not Found" may be used instead. */
	const GONE = 410;

	/** The request did not specify the length of its content, which is required by the requested resource. */
	const LENGTH_REQUIRED = 411;

	/** The server does not meet one of the preconditions that the requester put on the request header fields. */
	const PRECONDITION_FAILED = 412;

	/** The request is larger than the server is willing or able to process. Previously called "Request Entity Too Large". */
	const PAYLOAD_TOO_LARGE = 413;

	/** The URI provided was too long for the server to process. Often the result of too much data being encoded as a query-string of a GET request, in which case it should be converted to a POST request. Called "Request-URI Too Long" previously. */
	const URI_TOO_LONG = 414;

	/** The request entity has a media type which the server or resource does not support. For example, the client uploads an image as image/svg+xml, but the server requires that images use a different format. */
	const UNSUPPORTED_MEDIA_TYPE = 415;

	/** The client has asked for a portion of the file (byte serving), but the server cannot supply that portion. For example, if the client asked for a part of the file that lies beyond the end of the file. Called "Requested Range Not Satisfiable" previously. */
	const RANGE_NOT_SATISFIABLE = 416;

	/** The server cannot meet the requirements of the Expect request-header field. */
	const EXPECTATION_FAILED = 417;

	/** This code was defined in 1998 as one of the traditional IETF April Fools' jokes, in RFC 2324, Hyper Text Coffee Pot Control Protocol, and is not expected to be implemented by actual HTTP servers. The RFC specifies this code should be returned by teapots requested to brew coffee. This HTTP status is used as an Easter egg in some websites, including Google.com. */
	const IM_A_TEAPOT = 418;

	/** The request was directed at a server that is not able to produce a response (for example because of connection reuse). */
	const MISDIRECTED_REQUEST = 421;

	/** The request was well-formed but was unable to be followed due to semantic errors. */
	const UNPROCESSABLE_ENTITY = 422;

	/** The resource that is being accessed is locked. */
	const LOCKED = 423;

	/** The request failed because it depended on another request and that request failed (e.g., a PROPPATCH). */
	const FAILED_DEPENDENCY = 424;

	/** Indicates that the server is unwilling to risk processing a request that might be replayed. */
	const TOO_EARLY = 425;

	/** The client should switch to a different protocol such as TLS/1.0, given in the Upgrade header field. */
	const UPGRADE_REQUIRED = 426;

	/** The origin server requires the request to be conditional. Intended to prevent the 'lost update' problem, where a client GETs a resource's state, modifies it, and PUTs it back to the server, when meanwhile a third party has modified the state on the server, leading to a conflict. */
	const PRECONDITION_REQUIRED = 428;

	/** The user has sent too many requests in a given amount of time. Intended for use with rate-limiting schemes. */
	const TOO_MANY_REQUESTS = 429;

	/** The server is unwilling to process the request because either an individual header field, or all the header fields collectively, are too large. */
	const REQUEST_HEADER_FIELDS_TOO_LARGE = 431;

	/** A server operator has received a legal demand to deny access to a resource or to a set of resources that includes the requested resource. The code 451 was chosen as a reference to the novel Fahrenheit 451 (see the Acknowledgements in the RFC). */
	const UNAVAILABLE_FOR_LEGAL_REASONS = 451;

	/** A generic error message, given when an unexpected condition was encountered and no more specific message is suitable. */
	const INTERNAL_SERVER_ERROR = 500;

	/** The server either does not recognize the request method, or it lacks the ability to fulfil the request. Usually this implies future availability (e.g., a new feature of a web-service API). */
	const NOT_IMPLEMENTED = 501;

	/** The server was acting as a gateway or proxy and received an invalid response from the upstream server. */
	const BAD_GATEWAY = 502;

	/** The server cannot handle the request (because it is overloaded or down for maintenance). Generally, this is a temporary state. */
	const SERVICE_UNAVAILABLE = 503;

	/** The server was acting as a gateway or proxy and did not receive a timely response from the upstream server. */
	const GATEWAY_TIMEOUT = 504;

	/** The server does not support the HTTP protocol version used in the request. */
	const HTTP_VERSION_NOT_SUPPORTED = 505;

	/** Transparent content negotiation for the request results in a circular reference. */
	const VARIANT_ALSO_NEGOTIATES = 506;

	/** The server is unable to store the representation needed to complete the request. */
	const INSUFFICIENT_STORAGE = 507;

	/** The server detected an infinite loop while processing the request (sent instead of 208 Already Reported). */
	const LOOP_DETECTED = 508;

	/** Further extensions to the request are required for the server to fulfil it. */
	const NOT_EXTENDED = 510;

	/** The client needs to authenticate to gain network access. Intended for use by intercepting proxies used to control access to the network (e.g., "captive portals" used to require agreement to Terms of Service before granting full Internet access via a Wi-Fi hotspot). */
	const NETWORK_AUTHENTICATION_REQUIRED = 511;

	/**
	 * Used in the resumable requests proposal to resume aborted PUT or POST requests.
	 * Unofficial codes: this code is not specified by any standard.
	 */
	const CHECKPOINT = 103;

	/**
	 * Used as a catch-all error condition for allowing response bodies to flow through Apache when ProxyErrorOverride is enabled. When ProxyErrorOverride is enabled in Apache, response bodies that contain a status code of 4xx or 5xx are automatically discarded by Apache in favor of a generic response or a custom response specified by the ErrorDocument directive.
	 * Unofficial codes: this code is not specified by any standard.
	 */
	const THIS_IS_FINE = 218;

	/**
	 * Used by the Laravel Framework when a CSRF Token is missing or expired.
	 * Unofficial codes: this code is not specified by any standard.
	 */
	const PAGE_EXPIRED = 419;

	/**
	 * A deprecated response used by the Spring Framework when a method has failed.
	 * Unofficial codes: this code is not specified by any standard.
	 */
	const METHOD_FAILURE = 420;

	/**
	 * Returned by version 1 of the Twitter Search and Trends API when the client is being rate limited; versions 1.1 and later use the 429 Too Many Requests response code instead.
	 * Unofficial codes: this code is not specified by any standard.
	 */
	const ENHANCE_YOUR_CALM = 420;

	/**
	 * Used by Shopify, instead of the 429 Too Many Requests response code, when too many URLs are requested within a certain time frame.
	 * Unofficial codes: this code is not specified by any standard.
	 */
	const SHOPIFY_REQUEST_HEADER_FIELDS_TOO_LARGE = 430;

	/**
	 * The Microsoft extension code indicated when Windows Parental Controls are turned on and are blocking access to the requested webpage.
	 * Unofficial codes: this code is not specified by any standard.
	 */
	const BLOCKED_BY_WINDOWS_PARENTAL_CONTROLS = 450;

	/**
	 * Returned by ArcGIS for Server. Code 498 indicates an expired or otherwise invalid token.
	 * Unofficial codes: this code is not specified by any standard.
	 */
	const INVALID_TOKEN = 498;

	/**
	 * Returned by ArcGIS for Server. Code 499 indicates that a token is required but was not submitted.
	 * Unofficial codes: this code is not specified by any standard.
	 */
	const TOKEN_REQUIRED = 499;

	/**
	 * The server has exceeded the bandwidth specified by the server administrator; this is often used by shared hosting providers to limit the bandwidth of customers.
	 * Unofficial codes: this code is not specified by any standard.
	 */
	const BANDWIDTH_LIMIT_EXCEEDED = 509;

	/**
	 * Used by Cloudflare and Cloud Foundry's gorouter to indicate failure to validate the SSL/TLS certificate that the origin server presented.
	 * Unofficial codes: this code is not specified by any standard.
	 */
	const INVALID_SSL_CERTIFICATE = 526;

	/**
	 * Used by Qualys in the SSLLabs server testing API to signal that the site can't process the request.
	 * Unofficial codes: this code is not specified by any standard.
	 */
	const SITE_IS_OVERLOADED = 529;

	/**
	 * Used by the Pantheon web platform to indicate a site that has been frozen due to inactivity.
	 * Unofficial codes: this code is not specified by any standard.
	 */
	const SITE_IS_FROZEN = 530;

	/**
	 * Used by some HTTP proxies to signal a network read timeout behind the proxy to a client in front of the proxy.
	 * Unofficial codes: this code is not specified by any standard.
	 */
	const NETWORK_READ_TIMEOUT_ERROR = 598;

	/**
	 * The client's session has expired and must log in again.
	 * Internet Information Services: Microsoft's Internet Information Services web server expands the 4xx error space to signal errors with the client's request.
	 */
	const LOGIN_TIME_OUT = 440;

	/**
	 * The server cannot honour the request because the user has not provided the required information.
	 * Internet Information Services: Microsoft's Internet Information Services web server expands the 4xx error space to signal errors with the client's request.
	 */
	const RETRY_WITH = 449;

	/**
	 * Used in Exchange ActiveSync when either a more efficient server is available or the server cannot access the users' mailbox. The client is expected to re-run the HTTP AutoDiscover operation to find a more appropriate server.
	 * Internet Information Services: Microsoft's Internet Information Services web server expands the 4xx error space to signal errors with the client's request.
	 */
	const REDIRECT = 451;

	/**
	 * Used internally to instruct the server to return no information to the client and close the connection immediately.
	 * nginx: The nginx web server software expands the 4xx error space to signal issues with the client's request.
	 */
	const NO_RESPONSE = 444;

	/**
	 * Client sent too large request or too long header line.
	 * nginx: The nginx web server software expands the 4xx error space to signal issues with the client's request.
	 */
	const REQUEST_HEADER_TOO_LARGE = 494;

	/**
	 * An expansion of the 400 Bad Request response code, used when the client has provided an invalid client certificate.
	 * nginx: The nginx web server software expands the 4xx error space to signal issues with the client's request.
	 */
	const SSL_CERTIFICATE_ERROR = 495;

	/**
	 * An expansion of the 400 Bad Request response code, used when a client certificate is required but not provided.
	 * nginx: The nginx web server software expands the 4xx error space to signal issues with the client's request.
	 */
	const SSL_CERTIFICATE_REQUIRED = 496;

	/**
	 * An expansion of the 400 Bad Request response code, used when the client has made a HTTP request to a port listening for HTTPS requests.
	 * nginx: The nginx web server software expands the 4xx error space to signal issues with the client's request.
	 */
	const HTTP_REQUEST_SENT_TO_HTTPS_PORT = 497;

	/**
	 * Used when the client has closed the request before the server could send a response.
	 * nginx: The nginx web server software expands the 4xx error space to signal issues with the client's request.
	 */
	const CLIENT_CLOSED_REQUEST = 499;

	/**
	 * The origin server returned an empty, unknown, or unexplained response to Cloudflare.
	 * Cloudflare: Cloudflare's reverse proxy service expands the 5xx series of errors space to signal issues with the origin server.
	 */
	const WEB_SERVER_RETURNED_AN_UNKNOWN_ERROR = 520;

	/**
	 * The origin server has refused the connection from Cloudflare.
	 * Cloudflare: Cloudflare's reverse proxy service expands the 5xx series of errors space to signal issues with the origin server.
	 */
	const WEB_SERVER_IS_DOWN = 521;

	/**
	 * Cloudflare could not negotiate a TCP handshake with the origin server.
	 * Cloudflare: Cloudflare's reverse proxy service expands the 5xx series of errors space to signal issues with the origin server.
	 */
	const CONNECTION_TIMED_OUT = 522;

	/**
	 * Cloudflare could not reach the origin server; for example, if the DNS records for the origin server are incorrect.
	 * Cloudflare: Cloudflare's reverse proxy service expands the 5xx series of errors space to signal issues with the origin server.
	 */
	const ORIGIN_IS_UNREACHABLE = 523;

	/**
	 * Cloudflare was able to complete a TCP connection to the origin server, but did not receive a timely HTTP response.
	 * Cloudflare: Cloudflare's reverse proxy service expands the 5xx series of errors space to signal issues with the origin server.
	 */
	const A_TIMEOUT_OCCURRED = 524;

	/**
	 * Cloudflare could not negotiate a SSL/TLS handshake with the origin server.
	 * Cloudflare: Cloudflare's reverse proxy service expands the 5xx series of errors space to signal issues with the origin server.
	 */
	const SSL_HANDSHAKE_FAILED = 525;

	/**
	 * Error 527 indicates an interrupted connection between Cloudflare and the origin server's Railgun server.
	 * Cloudflare: Cloudflare's reverse proxy service expands the 5xx series of errors space to signal issues with the origin server.
	 */
	const RAILGUN_ERROR = 527;
}
