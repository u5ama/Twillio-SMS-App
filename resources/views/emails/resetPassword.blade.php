{{--@include('emails.emailHeader')--}}
{{--@if($app_local=='en')--}}
{{--    <tr>--}}
{{--        <td class="body" width="100%" cellpadding="0"--}}
{{--            style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Nunito Sans', sans-serif; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; background-color: #edf2f7; border-bottom: 1px solid #edf2f7; border-top: 1px solid #edf2f7; margin: 0; padding: 0; width: 100%;">--}}
{{--            <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0"--}}
{{--                   role="presentation"--}}
{{--                   style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Nunito Sans', sans-serif; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px; background-color: #ffffff; border-color: #e8e5ef; border-radius: 2px; border-width: 1px; box-shadow: 0 2px 0 rgba(0, 0, 150, 0.025), 2px 4px 0 rgba(0, 0, 150, 0.015); margin: 0 auto; padding: 0; width: 570px;">--}}
{{--                <!-- Body content -->--}}
{{--                <tr>--}}
{{--                    <td class="content-cell"--}}
{{--                        style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Nunito Sans', sans-serif; position: relative; max-width: 100vw; padding: 32px;">--}}
{{--                        <p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Nunito Sans', sans-serif; font-weight:bold;position: relative; font-size: 16pt; line-height: 1.5em; margin-top: 0; text-align: left;color:#070201">--}}
{{--                          Hey, {{ $name }}--}}
{{--                        </p>--}}
{{--                        <p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Nunito Sans', sans-serif; position: relative; font-size: 13pt; line-height: 1.5em; margin-top: 0; text-align: left;color:#070201">--}}
{{--                            {{ config('languageString.forgot_password_body') }}--}}
{{--                        </p>--}}

{{--                        <p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Nunito Sans', sans-serif; position: relative; font-size: 13pt; line-height: 1.5em; margin-top: 0; text-align: left;color:#070201">--}}
{{--                            {{ config('languageString.forgot_password_subject') }}--}}
{{--                        </p>--}}

{{--                        <p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Nunito Sans', sans-serif; position: relative; font-size: 16px; line-height: 1.5em; margin:35px 0 35px 0; text-align: center;">--}}
{{--                            <a href="{{ $actionUrl }}"--}}
{{--                               style="background-image: linear-gradient(to right, #1F9AC6 0%, #0286b8 100%);text-decoration: none;color: #242525;font-size: 21pt;line-height: 26pt;width:100%;padding: 10px 30px 10px 20px;border-radius:50px;text-transform: uppercase;font-weight: bold;">STAY--}}
{{--                                {{ config('languageString.forgot_password_button_text') }}--}}
{{--                            </a>--}}
{{--                        </p>--}}

{{--                    </td>--}}
{{--                </tr>--}}
{{--            </table>--}}
{{--        </td>--}}
{{--    </tr>--}}
{{--@else--}}
{{--    <tr>--}}
{{--        <td class="body" width="100%" cellpadding="0"--}}
{{--            style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Nunito Sans', sans-serif; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; background-color: #edf2f7; border-bottom: 1px solid #edf2f7; border-top: 1px solid #edf2f7; margin: 0; padding: 0; width: 100%;">--}}
{{--            <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0"--}}
{{--                   role="presentation"--}}
{{--                   style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Nunito Sans', sans-serif; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px; background-color: #ffffff; border-color: #e8e5ef; border-radius: 2px; border-width: 1px; box-shadow: 0 2px 0 rgba(0, 0, 150, 0.025), 2px 4px 0 rgba(0, 0, 150, 0.015); margin: 0 auto; padding: 0; width: 570px;">--}}
{{--                <!-- Body content -->--}}
{{--                <tr>--}}
{{--                    <td class="content-cell"--}}
{{--                        style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Nunito Sans', sans-serif; position: relative; max-width: 100vw; padding: 32px;">--}}
{{--                        <p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Nunito Sans', sans-serif; font-weight:bold;position: relative; font-size: 16pt; line-height: 1.5em; margin-top: 0; text-align: right;color:#070201;direction:rtl"--}}
{{--                           dir="rtl">--}}
{{--                            {{ config('languageString.hey') }} {{ $name }}--}}
{{--                        </p>--}}
{{--                        <p dir="rtl" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Nunito Sans', sans-serif; position: relative; font-size: 13pt; line-height: 1.5em; margin-top: 0; color:#070201">--}}
{{--                            {{ config('languageString.forgot_password_body') }}--}}
{{--                        </p>--}}
{{--                        <p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Nunito Sans', sans-serif; position: relative; font-size: 16px; line-height: 1.5em; margin:35px 0 35px 0; text-align: center;">--}}
{{--                            <a href="{{ $actionUrl }}"--}}
{{--                               style="background-image: linear-gradient(to right, #1F9AC6 0%, #0286b8 100%);text-decoration: none;color: #242525;font-size: 21pt;line-height: 26pt;width:100%;padding: 10px 30px 10px 20px;border-radius:50px;text-transform: uppercase;font-weight: bold;">STAY--}}
{{--                                {{ config('email_string.forgot_password_button_text') }}--}}
{{--                            </a>--}}
{{--                        </p>--}}
{{--                    </td>--}}
{{--                </tr>--}}
{{--            </table>--}}
{{--        </td>--}}
{{--    </tr>--}}
{{--@endif--}}
{{--@include('emails.emailFooter')--}}


@include('emails.emailHeader')
@if($app_local=='en')
    <div style="background-color:transparent;">
        <div class="block-grid"
             style="min-width: 320px; max-width: 640px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: #80e613;">
            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#80e613;">
                <!--[if (mso)|(IE)]>
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;">
                    <tr>
                        <td align="center">
                            <table cellpadding="0" cellspacing="0" border="0" style="width:640px">
                                <tr class="layout-full-width" style="background-color:#80e613"><![endif]-->
                <!--[if (mso)|(IE)]>
                <td align="center" width="640"
                    style="background-color:#80e613;width:640px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;"
                    valign="top">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;">
                <![endif]-->
                <div class="col num12"
                     style="min-width: 320px; max-width: 640px; display: table-cell; vertical-align: top; width: 640px;">
                    <div class="col_cont" style="width:100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div
                            style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                            <!--<![endif]-->
                            <!--[if mso]>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="padding-right: 40px; padding-left: 40px; padding-top: 10px; padding-bottom: 10px; font-family: Tahoma, sans-serif">
                            <![endif]-->
                            <div
                                style="color:#555555;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;line-height:1.2;padding-top:10px;padding-right:40px;padding-bottom:10px;padding-left:40px;">
                                <div class="txtTinyMce-wrapper"
                                     style="line-height: 1.2; font-size: 12px; color: #555555; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif; mso-line-height-alt: 14px;">
                                    <p style="font-size: 30px; line-height: 1.2; text-align: center; word-break: break-word; mso-line-height-alt: 36px; margin: 0;">
                                        <span
                                            style="font-size: 30px; color: #000000;"><strong>{{ $main_title_text }}</strong></span>
                                    </p>
                                </div>
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
                            <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                    </div>
                </div>
                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
            </div>
        </div>
    </div>
    <div style="background-color:transparent;">
        <div class="block-grid"
             style="min-width: 320px; max-width: 640px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: #fff;">
            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#fff;">
                <!--[if (mso)|(IE)]>
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;">
                    <tr>
                        <td align="center">
                            <table cellpadding="0" cellspacing="0" border="0" style="width:640px">
                                <tr class="layout-full-width" style="background-color:#fff"><![endif]-->
                <!--[if (mso)|(IE)]>
                <td align="center" width="640"
                    style="background-color:#fff;width:640px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;"
                    valign="top">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td style="padding-right: 0px; padding-left: 0px; padding-top:0px; padding-bottom:0px;">
                <![endif]-->
                <div class="col num12"
                     style="min-width: 320px; max-width: 640px; display: table-cell; vertical-align: top; width: 640px;">
                    <div class="col_cont" style="width:100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div
                            style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:0px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;">
                            <!--<![endif]-->
                            <!--[if mso]>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="padding-right: 40px; padding-left: 40px; padding-top: 30px; padding-bottom: 10px; font-family: Tahoma, sans-serif">
                            <![endif]-->
                            <div
                                style="color:#555555;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;line-height:1.2;padding-top:30px;padding-right:40px;padding-bottom:10px;padding-left:40px;">
                                <div class="txtTinyMce-wrapper"
                                     style="line-height: 1.2; font-size: 12px; color: #555555; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif; mso-line-height-alt: 14px;">
                                    <p dir="ltr"
                                       style="font-size: 16px; line-height: 1.2; word-break: break-word; text-align: justify; mso-line-height-alt: 19px; margin: 0;">
                                        <span style="font-size: 16px;">{{trans('messages.hey')}} {{ $name }}</span>
                                    </p>
                                </div>
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
                            <!--[if mso]>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="padding-right: 40px; padding-left: 40px; padding-top: 10px; padding-bottom: 10px; font-family: Tahoma, sans-serif">
                            <![endif]-->
                            <div
                                style="color:#555555;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;line-height:1.5;padding-top:10px;padding-right:40px;padding-bottom:10px;padding-left:40px;">
                                <div class="txtTinyMce-wrapper"
                                     style="line-height: 1.5; font-size: 12px; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif; color: #555555; mso-line-height-alt: 18px;">
                                    <p style="font-size: 15px; line-height: 1.5; word-break: break-word; text-align: left; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif; mso-line-height-alt: 23px; margin: 0;">
                                        <span style="font-size: 15px;">body variable</span></p>
                                </div>
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
                            <div align="center" class="button-container"
                                 style="padding-top:15px;padding-right:10px;padding-bottom:0px;padding-left:10px;">
                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"><tr><td style="padding-top: 15px; padding-right: 10px; padding-bottom: 0px; padding-left: 10px" align="center"><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{ $actionUrl }}" style="height:46.5pt;width:175.5pt;v-text-anchor:middle;" arcsize="97%" stroke="false" fillcolor="#80e613"><w:anchorlock/><v:textbox inset="0,0,0,0"><center style="color:#000; font-family:Tahoma, sans-serif; font-size:16px"><![endif]-->
                                <a href="{{ $actionUrl }}"
                                   style="-webkit-text-size-adjust: none; text-decoration: none; display: inline-block; color: #000; background-color: #80e613; border-radius: 60px; -webkit-border-radius: 60px; -moz-border-radius: 60px; width: auto; width: auto; border-top: 1px solid #80e613; border-right: 1px solid #80e613; border-bottom: 1px solid #80e613; border-left: 1px solid #80e613; padding-top: 15px; padding-bottom: 15px; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif; text-align: center; mso-border-alt: none; word-break: keep-all;"
                                   target="_blank"><span
                                        style="padding-left:30px;padding-right:30px;font-size:16px;display:inline-block;letter-spacing:undefined;"><span
                                            style="font-size: 16px; margin: 0; line-height: 2; word-break: break-word; mso-line-height-alt: 32px;"><strong>{{ trans('messages.reset_button') }}</strong></span></span></a>
                                <!--[if mso]></center></v:textbox></v:roundrect></td></tr></table><![endif]-->
                            </div>
                            <!--[if mso]>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="padding-right: 40px; padding-left: 40px; padding-top: 30px; padding-bottom: 25px; font-family: Tahoma, sans-serif">
                            <![endif]-->
                            <div
                                style="color:#555555;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;line-height:1.2;padding-top:30px;padding-right:40px;padding-bottom:25px;padding-left:40px;">
                                <div class="txtTinyMce-wrapper"
                                     style="line-height: 1.2; font-size: 12px; color: #555555; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif; mso-line-height-alt: 14px;">
                                    <p dir="ltr"
                                       style="font-size: 16px; line-height: 1.2; word-break: break-word; text-align: justify; mso-line-height-alt: 19px; margin: 0;">
                                        <span
                                            style="font-size: 16px;">{{ trans('messages.global_footer_team_title') }}</span>
                                    </p>
                                    <p dir="ltr"
                                       style="font-size: 16px; line-height: 1.2; word-break: break-word; text-align: justify; mso-line-height-alt: 19px; margin: 0;">
                                        <span style="font-size: 16px;"><strong><span
                                                    style="">{{ trans('messages.global_footer_team_name') }}</span></strong></span>
                                    </p>
                                </div>
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
                            <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                    </div>
                </div>
                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
            </div>
        </div>
    </div>
@else
    <div style="background-color:transparent;">
        <div class="block-grid"
             style="min-width: 320px; max-width: 640px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: #80e613;">
            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#80e613;">
                <!--[if (mso)|(IE)]>
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;">
                    <tr>
                        <td align="center">
                            <table cellpadding="0" cellspacing="0" border="0" style="width:640px">
                                <tr class="layout-full-width" style="background-color:#80e613"><![endif]-->
                <!--[if (mso)|(IE)]>
                <td align="center" width="640"
                    style="background-color:#80e613;width:640px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;"
                    valign="top">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;">
                <![endif]-->
                <div class="col num12"
                     style="min-width: 320px; max-width: 640px; display: table-cell; vertical-align: top; width: 640px;">
                    <div class="col_cont" style="width:100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div
                            style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                            <!--<![endif]-->
                            <!--[if mso]>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="padding-right: 40px; padding-left: 40px; padding-top: 10px; padding-bottom: 10px; font-family: Tahoma, sans-serif">
                            <![endif]-->
                            <div
                                style="color:#555555;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;line-height:1.2;padding-top:10px;padding-right:40px;padding-bottom:10px;padding-left:40px;">
                                <div class="txtTinyMce-wrapper"
                                     style="line-height: 1.2; font-size: 12px; color: #555555; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif; mso-line-height-alt: 14px;">
                                    <p style="font-size: 30px; line-height: 1.2; text-align: center; word-break: break-word; mso-line-height-alt: 36px; margin: 0;">
                                        <span
                                            style="font-size: 30px; color: #000000;"><strong>{{ $main_title_text }}</strong></span>
                                    </p>
                                </div>
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
                            <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                    </div>
                </div>
                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
            </div>
        </div>
    </div>
    <div style="background-color:transparent;">
        <div class="block-grid"
             style="min-width: 320px; max-width: 640px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: #fff;">
            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#fff;">
                <!--[if (mso)|(IE)]>
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;">
                    <tr>
                        <td align="center">
                            <table cellpadding="0" cellspacing="0" border="0" style="width:640px">
                                <tr class="layout-full-width" style="background-color:#fff"><![endif]-->
                <!--[if (mso)|(IE)]>
                <td align="center" width="640"
                    style="background-color:#fff;width:640px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;"
                    valign="top">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td style="padding-right: 0px; padding-left: 0px; padding-top:0px; padding-bottom:0px;">
                <![endif]-->
                <div class="col num12"
                     style="min-width: 320px; max-width: 640px; display: table-cell; vertical-align: top; width: 640px;">
                    <div class="col_cont" style="width:100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div
                            style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:0px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;">
                            <!--<![endif]-->
                            <!--[if mso]>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="padding-right: 40px; padding-left: 40px; padding-top: 30px; padding-bottom: 10px; font-family: Tahoma, sans-serif">
                            <![endif]-->
                            <div
                                style="color:#555555;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;line-height:1.2;padding-top:30px;padding-right:40px;padding-bottom:10px;padding-left:40px;">
                                <div class="txtTinyMce-wrapper"
                                     style="line-height: 1.2; font-size: 12px; color: #555555; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif; mso-line-height-alt: 14px;">
                                    <p dir="rtl"
                                       style="font-size: 16px; line-height: 1.2; word-break: break-word; text-align: right; mso-line-height-alt: 19px; margin: 0;">
                                        <span style="font-size: 16px;">{{ $name }}</span></p>
                                </div>
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
                            <!--[if mso]>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="padding-right: 40px; padding-left: 40px; padding-top: 10px; padding-bottom: 10px; font-family: Tahoma, sans-serif">
                            <![endif]-->
                            <div
                                style="color:#555555;direction:rtl;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;line-height:1.5;padding-top:10px;padding-right:40px;padding-bottom:10px;padding-left:40px;">
                                <div class="txtTinyMce-wrapper"
                                     style="line-height: 1.5; font-size: 12px; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif; color: #555555; mso-line-height-alt: 18px;">
                                    <p dir="rtl"
                                       style="font-size: 15px; line-height: 1.5; word-break: break-word; text-align: right; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif; mso-line-height-alt: 23px; margin: 0;">
                                        <span style="font-size: 15px;"> {!! $body !!}</span></p>
                                </div>
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
                            <div align="center" class="button-container"
                                 style="padding-top:15px;padding-right:10px;padding-bottom:0px;padding-left:10px;">
                            <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"><tr><td style="padding-top: 15px; padding-right: 10px; padding-bottom: 0px; padding-left: 10px" align="center"><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{ $actionUrl }}" style="height:46.5pt;width:175.5pt;v-text-anchor:middle;" arcsize="97%" stroke="false" fillcolor="#80e613"><w:anchorlock/><v:textbox inset="0,0,0,0"><center style="color:#000; font-family:Tahoma, sans-serif; font-size:16px"><![endif]-->
                                <a href="{{ $actionUrl }}"
                                   style="-webkit-text-size-adjust: none; text-decoration: none; display: inline-block; color: #000; background-color: #80e613; border-radius: 60px; -webkit-border-radius: 60px; -moz-border-radius: 60px; width: auto; width: auto; border-top: 1px solid #80e613; border-right: 1px solid #80e613; border-bottom: 1px solid #80e613; border-left: 1px solid #80e613; padding-top: 15px; padding-bottom: 15px; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif; text-align: center; mso-border-alt: none; word-break: keep-all;"
                                   target="_blank"><span
                                        style="padding-left:30px;padding-right:30px;font-size:16px;display:inline-block;letter-spacing:undefined;"><span
                                            style="font-size: 16px; margin: 0; line-height: 2; word-break: break-word; mso-line-height-alt: 32px;"><strong>{{ trans('messages.reset_button') }}</strong></span></span></a>
                                <!--[if mso]></center></v:textbox></v:roundrect></td></tr></table><![endif]-->
                            </div>
                            <!--[if mso]>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="padding-right: 40px; padding-left: 40px; padding-top: 30px; padding-bottom: 25px; font-family: Tahoma, sans-serif">
                            <![endif]-->
                            <div
                                style="color:#555555;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;line-height:1.2;padding-top:30px;padding-right:40px;padding-bottom:25px;padding-left:40px;">
                                <div class="txtTinyMce-wrapper"
                                     style="line-height: 1.2; font-size: 12px; color: #555555; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif; mso-line-height-alt: 14px;">
                                    <p dir="rtl"
                                       style="font-size: 16px; line-height: 1.2; word-break: break-word; text-align: right; mso-line-height-alt: 19px; margin: 0;">
                                        <span
                                            style="font-size: 16px;">{{ trans('messages.global_footer_team_title') }}</span>
                                    </p>
                                    <p dir="rtl"
                                       style="font-size: 16px; line-height: 1.2; word-break: break-word; text-align: right; mso-line-height-alt: 19px; margin: 0;">
                                        <span style="font-size: 16px;"><strong><span
                                                    style="">{{ trans('messages.global_footer_team_name') }}</span></strong></span>
                                    </p>
                                </div>
                            </div>
                            <!--[if mso]></td></tr></table><![endif]-->
                            <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                    </div>
                </div>
                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
            </div>
        </div>
    </div>
@endif
@include('emails.emailFooter')

