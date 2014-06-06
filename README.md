<a href="http://mapply.net"><img src="http://mapply.net/img/logo.png" /></a>
Mapply-WordPress-Plugin
=======================

A plugin that adds your mapply map to your WordPress website via shortcode. Sign up for your Mapply free trial on <a href="http://mapply.net">Mapply.net</a>. Once you have signed up you will need your API key and a Google Maps API key. 

Usage
------
In order to use the Mapply WordPress plugin you will need to save your Mapply API key (found in your Mapply settings).
You will need to save these keys in the settings page in your WordPress admin dashboard. Once saved you can use the [mapply] shortcode.

Shortcode:
<pre>
[mapply]
</pre>

The plugin will replace the shortcode with the standard mapply JavaScript snippet.
<pre>
<script id="locator" type="text/javascript" src="//app.mapply.net/front-end/js/locator.js" data-api-key="store_locator.[Mapply_API]" data-path="//app.mapply.net/front-end/" data-maps-api-key="[Google_API]" ></script>
</pre>

FAQ
---
<ul>
  <li><b>Q:</b>Where do I get a Mapply account?</li>
  <li><b>A:</b>You can sign up on <a href="http://mapply.net">Mapply.net</a></li>
</ul>
<ul>
  <li><b>Q:</b>Do I need the WordPress plugin to use Mapply with WordPress?</li>
  <li><b>A:</b>No, you can insert the JavaScript code directly into your website. The Shortcode is to make it easier for you.</li>
</ul>
<ul>
  <li><b>Q:</b>What is a Shortcode?</li>
  <li><b>A:</b><a href="http://codex.wordpress.org/Shortcode">Shortcodes</a> are macros supported by WordPress which make inserting code into your posts easier for you.</li>
</ul>
<ul>
  <li><b>Q:</b>Does the WordPress plugin cost anything?</li>
  <li><b>A:</b>This plugin is free with your Mapply subscription.</li>
</ul>
