<?php
$title = "Home";
require_once 'head.php';

?>
<h2 align="center">Contact Us</h2>

<div style="display:block;" align="center">
<form id="contact" name="contact" method="post" action="submit.php">
    <table>
        <tr>
            <td align="right">
                Contact Name: 
                <span class="required">*</span>
            </td>
            <td align="left">
                <input type="text" name="contact_name" id="contact_name" size="32">
            </td>
        </tr>
        <tr>
            <td align="right">
                Company Name: 
                <span class="required">*</span>
            </td>
            <td align="left">
                <input type="text" name="company_name" id="company_name" size="32">
            </td>
        </tr>
        <tr>
            <td align="right">
                Email: 
                <span class="required">*</span>
            </td>
            <td align="left">
                <input type="text" name="email" id="email" size="32">
            </td>
        </tr>
        <tr>
            <td align="right">
                Comments: 
                <span class="required">*</span>
            </td>
            <td align="left">
                <textarea name="comments" id="comments" rows="8" cols="30"></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                Please enter the characters you see here:<span class="required">*</span><a href='http://en.wikipedia.org/wiki/Captcha' target='blank'><span class="tip" onMouseOver="tooltip('This CAPTCHA is to tell whether it is a human or computer bot submitting this form.');" onMouseOut="exit();">?</span></a><input name="txtCaptcha" type="text" class="required_box" id="txtCaptcha" size="10">
                <br>
                <img id="imgCaptcha" src="/captcha.php" />
                <br>
                <input id="refresh" type="button" value="Change Image" name="refresh" onClick="document.getElementById('imgCaptcha').src='/captcha.php' + '?' + (new Date()).getTime();"/>
            </td>
        </tr>
        <tr>
            <td align="right" colspan="2">
                <input type="submit" value="Submit">
            </td>
        </tr>
    </table>
</form>
</div>


<?
require_once 'foot.php';
?>
