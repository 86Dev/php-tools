<?php

declare(strict_types = 1);

namespace PHPTools;

/**
 * Provides shortcut to access $_SERVER values.
 *
 * @see https://www.php.net/manual/en/reserved.variables.server
 *
 * @version 1.3.0
 * @author 86Dev
 */
abstract class ServerArray
{
	/**
	 * The filename of the currently executing script, relative to the document root. For instance, $_SERVER['PHP_SELF'] in a script at the address http://example.com/foo/bar.php would be /foo/bar.php. The __FILE__ constant contains the full path and filename of the current (i.e. included) file. If PHP is running as a command-line processor this variable contains the script name since PHP 4.3.0. Previously it was not available.
	 *
	 * @return string
	 */
	public static function php_self()
	{
		return array_key_exists('PHP_SELF', $_SERVER) ? $_SERVER['PHP_SELF'] : '';
	}

	/**
	 * Array of arguments passed to the script. When the script is run on the command line, this gives C-style access to the command line parameters. When called via the GET method, this will contain the query string.
	 *
	 * @return array
	 */
	public static function argv()
	{
		return array_key_exists('argv', $_SERVER) ? $_SERVER['argv'] : '';
	}

	/**
	 * Contains the number of command line parameters passed to the script (if run on the command line).
	 *
	 * @return string
	 */
	public static function argc()
	{
		return array_key_exists('argc', $_SERVER) ? $_SERVER['argc'] : '';
	}

	/**
	 * What revision of the CGI specification the server is using; e.g. 'CGI/1.1'.
	 *
	 * @return string
	 */
	public static function gateway_interface()
	{
		return array_key_exists('GATEWAY_INTERFACE', $_SERVER) ? $_SERVER['GATEWAY_INTERFACE'] : '';
	}

	/**
	 * The IP address of the server under which the current script is executing.
	 *
	 * @return string
	 */
	public static function server_addr()
	{
		return array_key_exists('SERVER_ADDR', $_SERVER) ? $_SERVER['SERVER_ADDR'] : '';
	}

	/**
	 * The name of the server host under which the current script is executing. If the script is running on a virtual host, this will be the value defined for that virtual host.
	 * Note: Under Apache 2, you must set UseCanonicalName = On and ServerName. Otherwise, this value reflects the hostname supplied by the client, which can be spoofed. It is not safe to rely on this value in security-dependent contexts.
	 *
	 * @return string
	 */
	public static function server_name()
	{
		return array_key_exists('SERVER_NAME', $_SERVER) ? $_SERVER['SERVER_NAME'] : '';
	}

	/**
	 * Server identification string, given in the headers when responding to requests.
	 *
	 * @return string
	 */
	public static function server_software()
	{
		return array_key_exists('SERVER_SOFTWARE', $_SERVER) ? $_SERVER['SERVER_SOFTWARE'] : '';
	}

	/**
	 * Name and revision of the information protocol via which the page was requested; e.g. 'HTTP/1.0';
	 *
	 * @return string
	 */
	public static function server_protocol()
	{
		return array_key_exists('SERVER_PROTOCOL', $_SERVER) ? $_SERVER['SERVER_PROTOCOL'] : '';
	}

	/**
	 * Which request method was used to access the page; e.g. 'GET', 'HEAD', 'POST', 'PUT'.
	 * Note: PHP script is terminated after sending headers (it means after producing any output without output buffering) if the request method was HEAD.
	 *
	 * @return string
	 */
	public static function request_method()
	{
		return array_key_exists('REQUEST_METHOD', $_SERVER) ? $_SERVER['REQUEST_METHOD'] : '';
	}

	/**
	 * The timestamp of the start of the request. Available since PHP 5.1.0.
	 *
	 * @return string
	 */
	public static function request_time()
	{
		return array_key_exists('REQUEST_TIME', $_SERVER) ? $_SERVER['REQUEST_TIME'] : '';
	}

	/**
	 * The timestamp of the start of the request, with microsecond precision. Available since PHP 5.4.0.
	 *
	 * @return string
	 */
	public static function request_time_float()
	{
		return array_key_exists('REQUEST_TIME_FLOAT', $_SERVER) ? $_SERVER['REQUEST_TIME_FLOAT'] : '';
	}

	/**
	 * The query string, if any, via which the page was accessed.
	 *
	 * @return string
	 */
	public static function query_string()
	{
		return array_key_exists('QUERY_STRING', $_SERVER) ? $_SERVER['QUERY_STRING'] : '';
	}

	/**
	 * The document root directory under which the current script is executing, as defined in the server's configuration file.
	 *
	 * @return string
	 */
	public static function document_root()
	{
		return array_key_exists('DOCUMENT_ROOT', $_SERVER) ? $_SERVER['DOCUMENT_ROOT'] : '';
	}

	/**
	 * Contents of the Accept: header from the current request, if there is one.
	 *
	 * @return string
	 */
	public static function http_accept()
	{
		return array_key_exists('HTTP_ACCEPT', $_SERVER) ? $_SERVER['HTTP_ACCEPT'] : '';
	}

	/**
	 * Contents of the Accept-Charset: header from the current request, if there is one. Example: 'iso-8859-1,*,utf-8'.
	 *
	 * @return string
	 */
	public static function http_accept_charset()
	{
		return array_key_exists('HTTP_ACCEPT_CHARSET', $_SERVER) ? $_SERVER['HTTP_ACCEPT_CHARSET'] : '';
	}

	/**
	 *Contents of the Accept-Encoding: header from the current request, if there is one. Example: 'gzip'.
	 *
	 * @return string
	 */
	public static function http_accept_encoding()
	{
		return array_key_exists('HTTP_ACCEPT_ENCODING', $_SERVER) ? $_SERVER['HTTP_ACCEPT_ENCODING'] : '';
	}

	/**
	 * Contents of the Accept-Language: header from the current request, if there is one. Example: 'en'.
	 *
	 * @return string
	 */
	public static function http_accept_language()
	{
		return array_key_exists('HTTP_ACCEPT_LANGUAGE', $_SERVER) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : '';
	}

	/**
	 * Contents of the Connection: header from the current request, if there is one. Example: 'Keep-Alive'.
	 *
	 * @return string
	 */
	public static function http_connection()
	{
		return array_key_exists('HTTP_CONNECTION', $_SERVER) ? $_SERVER['HTTP_CONNECTION'] : '';
	}

	/**
	 * Contents of the Host: header from the current request, if there is one.
	 *
	 * @return string
	 */
	public static function http_host()
	{
		return array_key_exists('HTTP_HOST', $_SERVER) ? $_SERVER['HTTP_HOST'] : '';
	}

	/**
	 * The address of the page (if any) which referred the user agent to the current page. This is set by the user agent. Not all user agents will set this, and some provide the ability to modify HTTP_REFERER as a feature. In short, it cannot really be trusted.
	 *
	 * @return string
	 */
	public static function http_referer()
	{
		return array_key_exists('HTTP_REFERER', $_SERVER) ? $_SERVER['HTTP_REFERER'] : '';
	}

	/**
	 * Contents of the User-Agent: header from the current request, if there is one. This is a string denoting the user agent being which is accessing the page. A typical example is: Mozilla/4.5 [en] (X11; U; Linux 2.2.9 i586). Among other things, you can use this value with get_browser() to tailor your page's output to the capabilities of the user agent.
	 *
	 * @return string
	 */
	public static function http_user_agent()
	{
		return array_key_exists('HTTP_USER_AGENT', $_SERVER) ? $_SERVER['HTTP_USER_AGENT'] : '';
	}

	/**
	 * Set to a non-empty value if the script was queried through the HTTPS protocol.
	 * Note: Note that when using ISAPI with IIS, the value will be off if the request was not made through the HTTPS protocol.
	 *
	 * @return string
	 */
	public static function https()
	{
		return array_key_exists('HTTPS', $_SERVER) ? $_SERVER['HTTPS'] : '';
	}

	/**
	 * The IP address from which the user is viewing the current page.
	 *
	 * @return string
	 */
	public static function remote_addr()
	{
		return array_key_exists('REMOTE_ADDR', $_SERVER) ? $_SERVER['REMOTE_ADDR'] : '';
	}

	/**
	 * The Host name from which the user is viewing the current page. The reverse dns lookup is based on the REMOTE_ADDR of the user.
	 * Note: Your web server must be configured to create this variable. For example in Apache you'll need HostnameLookups On inside httpd.conf for it to exist. See also gethostbyaddr().
	 *
	 * @return string
	 */
	public static function remote_host()
	{
		return array_key_exists('REMOTE_HOST', $_SERVER) ? $_SERVER['REMOTE_HOST'] : '';
	}

	/**
	 * The port being used on the user's machine to communicate with the web server.
	 *
	 * @return string
	 */
	public static function remote_port()
	{
		return array_key_exists('REMOTE_PORT', $_SERVER) ? $_SERVER['REMOTE_PORT'] : '';
	}

	/**
	 * The authenticated user.
	 *
	 * @return string
	 */
	public static function remote_user()
	{
		return array_key_exists('REMOTE_USER', $_SERVER) ? $_SERVER['REMOTE_USER'] : '';
	}

	/**
	 * The authenticated user if the request is internally redirected.
	 *
	 * @return string
	 */
	public static function redirect_remote_user()
	{
		return array_key_exists('REDIRECT_REMOTE_USER', $_SERVER) ? $_SERVER['REDIRECT_REMOTE_USER'] : '';
	}

	/**
	 * The absolute pathname of the currently executing script.
	 * Note: If a script is executed with the CLI, as a relative path, such as file.php or ../file.php, $_SERVER['SCRIPT_FILENAME'] will contain the relative path specified by the user.
	 *
	 * @return string
	 */
	public static function script_filename()
	{
		return array_key_exists('SCRIPT_FILENAME', $_SERVER) ? $_SERVER['SCRIPT_FILENAME'] : '';
	}

	/**
	 * The value given to the SERVER_ADMIN (for Apache) directive in the web server configuration file. If the script is running on a virtual host, this will be the value defined for that virtual host.
	 *
	 * @return string
	 */
	public static function server_admin()
	{
		return array_key_exists('SERVER_ADMIN', $_SERVER) ? $_SERVER['SERVER_ADMIN'] : '';
	}

	/**
	 * The port on the server machine being used by the web server for communication. For default setups, this will be '80'; using SSL, for instance, will change this to whatever your defined secure HTTP port is.
	 * Note: Under the Apache 2, you must set UseCanonicalName = On, as well as UseCanonicalPhysicalPort = On in order to get the physical (real) port, otherwise, this value can be spoofed and it may or may not return the physical port value. It is not safe to rely on this value in security-dependent contexts.
	 *
	 * @return string
	 */
	public static function server_port()
	{
		return array_key_exists('SERVER_PORT', $_SERVER) ? $_SERVER['SERVER_PORT'] : '';
	}

	/**
	 * String containing the server version and virtual host name which are added to server-generated pages, if enabled.
	 *
	 * @return string
	 */
	public static function server_signature()
	{
		return array_key_exists('SERVER_SIGNATURE', $_SERVER) ? $_SERVER['SERVER_SIGNATURE'] : '';
	}

	/**
	 * Filesystem- (not document root-) based path to the current script, after the server has done any virtual-to-real mapping.
	 * Note: As of PHP 4.3.2, PATH_TRANSLATED is no longer set implicitly under the Apache 2 SAPI in contrast to the situation in Apache 1, where it's set to the same value as the SCRIPT_FILENAME server variable when it's not populated by Apache. This change was made to comply with the CGI specification that PATH_TRANSLATED should only exist if PATH_INFO is defined. Apache 2 users may use AcceptPathInfo = On inside httpd.conf to define PATH_INFO.
	 *
	 * @return string
	 */
	public static function path_translated()
	{
		return array_key_exists('PATH_TRANSLATED', $_SERVER) ? $_SERVER['PATH_TRANSLATED'] : '';
	}

	/**
	 * Contains the current script's path. This is useful for pages which need to point to themselves. The __FILE__ constant contains the full path and filename of the current (i.e. included) file.
	 *
	 * @return string
	 */
	public static function script_name()
	{
		return array_key_exists('SCRIPT_NAME', $_SERVER) ? $_SERVER['SCRIPT_NAME'] : '';
	}

	/**
	 * The URI which was given in order to access this page; for instance, '/index.html'.
	 *
	 * @return string
	 */
	public static function request_uri()
	{
		return array_key_exists('REQUEST_URI', $_SERVER) ? $_SERVER['REQUEST_URI'] : '';
	}

	/**
	 * When doing Digest HTTP authentication this variable is set to the 'Authorization' header sent by the client (which you should then use to make the appropriate validation).
	 *
	 * @return string
	 */
	public static function php_auth_digest()
	{
		return array_key_exists('PHP_AUTH_DIGEST', $_SERVER) ? $_SERVER['PHP_AUTH_DIGEST'] : '';
	}

	/**
	 * When doing HTTP authentication this variable is set to the username provided by the user.
	 *
	 * @return string
	 */
	public static function php_auth_user()
	{
		return array_key_exists('PHP_AUTH_USER', $_SERVER) ? $_SERVER['PHP_AUTH_USER'] : '';
	}

	/**
	 * When doing HTTP authentication this variable is set to the password provided by the user.
	 *
	 * @return string
	 */
	public static function php_auth_pw()
	{
		return array_key_exists('PHP_AUTH_PW', $_SERVER) ? $_SERVER['PHP_AUTH_PW'] : '';
	}

	/**
	 * When doing HTTP authentication this variable is set to the authentication type.
	 *
	 * @return string
	 */
	public static function auth_type()
	{
		return array_key_exists('AUTH_TYPE', $_SERVER) ? $_SERVER['AUTH_TYPE'] : '';
	}

	/**
	 * Contains any client-provided pathname information trailing the actual script filename but preceding the query string, if available. For instance, if the current script was accessed via the URL http://www.example.com/php/path_info.php/some/stuff?foo=bar, then $_SERVER['PATH_INFO'] would contain /some/stuff.
	 *
	 * @return string
	 */
	public static function path_info()
	{
		return array_key_exists('PATH_INFO', $_SERVER) ? $_SERVER['PATH_INFO'] : '';
	}

	/**
	 * Original version of 'PATH_INFO' before processed by PHP.
	 *
	 * @return string
	 */
	public static function orig_path_info()
	{
		return array_key_exists('ORIG_PATH_INFO', $_SERVER) ? $_SERVER['ORIG_PATH_INFO'] : '';
	}

	/**
	 * Get the site url
	 *
	 * @return string
	 */
	public static function url()
	{
		return (!empty(static::HTTPS()) ? 'https' : 'http').'://'.static::SERVER_NAME().':'.static::SERVER_PORT();
	}
}
