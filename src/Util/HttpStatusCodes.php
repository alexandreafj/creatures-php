<?php

namespace App\Util;

/**
 * Class HttpStatusCode
 *
 * Provides a set of constants for common HTTP status codes.
 * This allows for more readable and maintainable code when setting
 * HTTP response statuses.
 *
 * Usage:
 * HttpStatusCode::OK (instead of 200)
 * HttpStatusCode::NOT_FOUND (instead of 404)
 */
final class HttpStatusCodes
{

    // --- 1xx Informational ---
    /**
     * HTTP 100 Continue
     * The server has received the request headers and the client should proceed to send the request body.
     */
    public const CONTINUE = 100;
    /**
     * HTTP 101 Switching Protocols
     * The requester has asked the server to switch protocols and the server has agreed to do so.
     */
    public const SWITCHING_PROTOCOLS = 101;
    /**
     * HTTP 102 Processing (WebDAV)
     * The server has received and is processing the request, but no response is available yet.
     */
    public const PROCESSING = 102;
    /**
     * HTTP 103 Early Hints
     * Used to return some response headers before final HTTP message.
     */
    public const EARLY_HINTS = 103;

    // --- 2xx Success ---
    /**
     * HTTP 200 OK
     * Standard response for successful HTTP requests.
     */
    public const OK = 200;
    /**
     * HTTP 201 Created
     * The request has been fulfilled, resulting in the creation of a new resource.
     */
    public const CREATED = 201;
    /**
     * HTTP 202 Accepted
     * The request has been accepted for processing, but the processing has not been completed.
     */
    public const ACCEPTED = 202;
    /**
     * HTTP 203 Non-Authoritative Information
     * The server is a transforming proxy that received a 200 OK from its origin,
     * but is returning a modified version of the origin's response.
     */
    public const NON_AUTHORITATIVE_INFORMATION = 203;
    /**
     * HTTP 204 No Content
     * The server successfully processed the request and is not returning any content.
     */
    public const NO_CONTENT = 204;
    /**
     * HTTP 205 Reset Content
     * The server successfully processed the request, but is not returning any content.
     * Unlike a 204 response, this response requires that the requester reset the document view.
     */
    public const RESET_CONTENT = 205;
    /**
     * HTTP 206 Partial Content
     * The server is delivering only part of the resource due to a range header sent by the client.
     */
    public const PARTIAL_CONTENT = 206;
    /**
     * HTTP 207 Multi-Status (WebDAV)
     * The message body that follows is an XML message and can contain a number of separate response codes,
     * depending on how many sub-requests were made.
     */
    public const MULTI_STATUS = 207;
    /**
     * HTTP 208 Already Reported (WebDAV)
     * The members of a DAV binding have already been enumerated in a previous reply to this request,
     * and are not being included again.
     */
    public const ALREADY_REPORTED = 208;
    /**
     * HTTP 226 IM Used (HTTP Delta encoding)
     * The server has fulfilled a GET request for the resource, and the response is a representation
     * of the result of one or more instance-manipulations applied to the current instance.
     */
    public const IM_USED = 226;

    // --- 3xx Redirection ---
    /**
     * HTTP 300 Multiple Choices
     * Indicates multiple options for the resource from which the client may choose.
     */
    public const MULTIPLE_CHOICES = 300;
    /**
     * HTTP 301 Moved Permanently
     * This and all future requests should be directed to the given URI.
     */
    public const MOVED_PERMANENTLY = 301;
    /**
     * HTTP 302 Found (Previously "Moved temporarily")
     * Tells the client to look at (browse to) another URL. 302 has been superseded by 303 and 307.
     */
    public const FOUND = 302;
    /**
     * HTTP 303 See Other
     * The response to the request can be found under another URI using the GET method.
     */
    public const SEE_OTHER = 303;
    /**
     * HTTP 304 Not Modified
     * Indicates that the resource has not been modified since the version specified by the request headers.
     */
    public const NOT_MODIFIED = 304;
    /**
     * HTTP 305 Use Proxy (Deprecated)
     * The requested resource is available only through a proxy, the address for which is provided in the response.
     * @deprecated
     */
    public const USE_PROXY = 305;
    /**
     * HTTP 307 Temporary Redirect
     * In this case, the request should be repeated with another URI; however, future requests should still use the original URI.
     */
    public const TEMPORARY_REDIRECT = 307;
    /**
     * HTTP 308 Permanent Redirect
     * The request and all future requests should be repeated using another URI.
     * 307 and 308 parallel the behaviors of 302 and 301, but do not allow the HTTP method to change.
     */
    public const PERMANENT_REDIRECT = 308;

    // --- 4xx Client Error ---
    /**
     * HTTP 400 Bad Request
     * The server cannot or will not process the request due to an apparent client error.
     */
    public const BAD_REQUEST = 400;
    /**
     * HTTP 401 Unauthorized
     * Similar to 403 Forbidden, but specifically for use when authentication is required and has failed or has not yet been provided.
     */
    public const UNAUTHORIZED = 401;
    /**
     * HTTP 402 Payment Required
     * Reserved for future use. The original intention was that this code might be used as part of some form of digital cash or micropayment scheme.
     */
    public const PAYMENT_REQUIRED = 402;
    /**
     * HTTP 403 Forbidden
     * The request was valid, but the server is refusing action.
     * The user might not have the necessary permissions for a resource.
     */
    public const FORBIDDEN = 403;
    /**
     * HTTP 404 Not Found
     * The requested resource could not be found but may be available in the future.
     */
    public const NOT_FOUND = 404;
    /**
     * HTTP 405 Method Not Allowed
     * A request method is not supported for the requested resource.
     */
    public const METHOD_NOT_ALLOWED = 405;
    /**
     * HTTP 406 Not Acceptable
     * The requested resource is capable of generating only content not acceptable according to the Accept headers sent in the request.
     */
    public const NOT_ACCEPTABLE = 406;
    /**
     * HTTP 407 Proxy Authentication Required
     * The client must first authenticate itself with the proxy.
     */
    public const PROXY_AUTHENTICATION_REQUIRED = 407;
    /**
     * HTTP 408 Request Timeout
     * The server timed out waiting for the request.
     */
    public const REQUEST_TIMEOUT = 408;
    /**
     * HTTP 409 Conflict
     * Indicates that the request could not be processed because of conflict in the request,
     * such as an edit conflict between multiple simultaneous updates.
     */
    public const CONFLICT = 409;
    /**
     * HTTP 410 Gone
     * Indicates that the resource requested is no longer available and will not be available again.
     */
    public const GONE = 410;
    /**
     * HTTP 411 Length Required
     * The request did not specify the length of its content, which is required by the requested resource.
     */
    public const LENGTH_REQUIRED = 411;
    /**
     * HTTP 412 Precondition Failed
     * The server does not meet one of the preconditions that the requester put on the request.
     */
    public const PRECONDITION_FAILED = 412;
    /**
     * HTTP 413 Payload Too Large (Formerly "Request Entity Too Large")
     * The request is larger than the server is willing or able to process.
     */
    public const PAYLOAD_TOO_LARGE = 413;
    /**
     * HTTP 414 URI Too Long (Formerly "Request-URI Too Long")
     * The URI provided was too long for the server to process.
     */
    public const URI_TOO_LONG = 414;
    /**
     * HTTP 415 Unsupported Media Type
     * The request entity has a media type which the server or resource does not support.
     */
    public const UNSUPPORTED_MEDIA_TYPE = 415;
    /**
     * HTTP 416 Range Not Satisfiable (Formerly "Requested Range Not Satisfiable")
     * The client has asked for a portion of the file, but the server cannot supply that portion.
     */
    public const RANGE_NOT_SATISFIABLE = 416;
    /**
     * HTTP 417 Expectation Failed
     * The server cannot meet the requirements of the Expect request-header field.
     */
    public const EXPECTATION_FAILED = 417;
    /**
     * HTTP 418 I'm a teapot (RFC 2324)
     * This code was defined in 1998 as one of the traditional IETF April Fools' jokes.
     */
    public const IM_A_TEAPOT = 418;
    /**
     * HTTP 421 Misdirected Request
     * The request was directed at a server that is not able to produce a response.
     */
    public const MISDIRECTED_REQUEST = 421;
    /**
     * HTTP 422 Unprocessable Entity (WebDAV)
     * The request was well-formed but was unable to be followed due to semantic errors.
     */
    public const UNPROCESSABLE_ENTITY = 422;
    /**
     * HTTP 423 Locked (WebDAV)
     * The resource that is being accessed is locked.
     */
    public const LOCKED = 423;
    /**
     * HTTP 424 Failed Dependency (WebDAV)
     * The request failed due to failure of a previous request (e.g., a PROPPATCH).
     */
    public const FAILED_DEPENDENCY = 424;
    /**
     * HTTP 425 Too Early
     * Indicates that the server is unwilling to risk processing a request that might be replayed.
     */
    public const TOO_EARLY = 425;
    /**
     * HTTP 426 Upgrade Required
     * The client should switch to a different protocol such as TLS/1.0, given in the Upgrade header field.
     */
    public const UPGRADE_REQUIRED = 426;
    /**
     * HTTP 428 Precondition Required
     * The origin server requires the request to be conditional.
     */
    public const PRECONDITION_REQUIRED = 428;
    /**
     * HTTP 429 Too Many Requests
     * The user has sent too many requests in a given amount of time ("rate limiting").
     */
    public const TOO_MANY_REQUESTS = 429;
    /**
     * HTTP 431 Request Header Fields Too Large
     * The server is unwilling to process the request because its header fields are too large.
     */
    public const REQUEST_HEADER_FIELDS_TOO_LARGE = 431;
    /**
     * HTTP 451 Unavailable For Legal Reasons
     * A server operator has received a legal demand to deny access to a resource or to a set of resources
     * that includes the requested resource.
     */
    public const UNAVAILABLE_FOR_LEGAL_REASONS = 451;

    // --- 5xx Server Error ---
    /**
     * HTTP 500 Internal Server Error
     * A generic error message, given when an unexpected condition was encountered and no more specific message is suitable.
     */
    public const INTERNAL_SERVER_ERROR = 500;
    /**
     * HTTP 501 Not Implemented
     * The server either does not recognize the request method, or it lacks the ability to fulfill the request.
     */
    public const NOT_IMPLEMENTED = 501;
    /**
     * HTTP 502 Bad Gateway
     * The server was acting as a gateway or proxy and received an invalid response from the upstream server.
     */
    public const BAD_GATEWAY = 502;
    /**
     * HTTP 503 Service Unavailable
     * The server is currently unavailable (because it is overloaded or down for maintenance). Generally, this is a temporary state.
     */
    public const SERVICE_UNAVAILABLE = 503;
    /**
     * HTTP 504 Gateway Timeout
     * The server was acting as a gateway or proxy and did not receive a timely response from the upstream server.
     */
    public const GATEWAY_TIMEOUT = 504;
    /**
     * HTTP 505 HTTP Version Not Supported
     * The server does not support the HTTP protocol version used in the request.
     */
    public const HTTP_VERSION_NOT_SUPPORTED = 505;
    /**
     * HTTP 506 Variant Also Negotiates
     * Transparent content negotiation for the request results in a circular reference.
     */
    public const VARIANT_ALSO_NEGOTIATES = 506;
    /**
     * HTTP 507 Insufficient Storage (WebDAV)
     * The server is unable to store the representation needed to complete the request.
     */
    public const INSUFFICIENT_STORAGE = 507;
    /**
     * HTTP 508 Loop Detected (WebDAV)
     * The server detected an infinite loop while processing the request.
     */
    public const LOOP_DETECTED = 508;
    /**
     * HTTP 510 Not Extended
     * Further extensions to the request are required for the server to fulfill it.
     */
    public const NOT_EXTENDED = 510;
    /**
     * HTTP 511 Network Authentication Required
     * The client needs to authenticate to gain network access.
     */
    public const NETWORK_AUTHENTICATION_REQUIRED = 511;

    /**
     * Private constructor to prevent instantiation.
     * This class is intended to be used statically.
     */
    private function __construct()
    {
    }
}
