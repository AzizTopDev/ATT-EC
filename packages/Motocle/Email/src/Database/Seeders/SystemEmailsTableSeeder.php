<?php

namespace Motocle\Email\Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class SystemEmailsTableSeeder extends Seeder
{
    public function run()
    {
        $systemEmails = [];

        $systemEmails[] = [
            'type' => 'customer.verification-email',
            'type_label' => 'Customer email verification',
            'sender_name' => 'Reptile',
            'sender_email' => 'shop@at-ec-dev.jp',
            'subject' => 'Reptile Verification Mail',
            'content' => '<strong>Reptile - Email Verification</strong><br /><br />Hello {customer_name}<br /><br />This is the mail to verify that the email address you entered is yours.<br /><br />Kindly click the Verify Your Account button below to verify your account.<br /><br /><br />[btn_url={email_verification_url}]Verify Your Account[/btn_url]',
            'variables' => serialize(['customer_name', 'email_verification_url']),
        ];

        $systemEmails[] = [
            'type' => 'customer.forget-password',
            'type_label' => 'Customer forgot password',
            'sender_name' => 'いきもの商店くすくす',
            'sender_email' => 'shop@at-ec-dev.jp',
            'subject' => '【くすくす】パスワードの再設定',
            'content' => '{customer_name} 様<br /><br />【いきもの商店くすくす】をご利用していただき、誠にありがとうございます。<br />現在後利用いただいております【いきもの商店くすくす】のパスワードを再発行についてお知らせ致します。<br />下記のボタンをクリックしていただき、新しいパスワードを設定をお願い致します。<br /><br /><br />[btn_url={password_reset_url}]パスワードの再設定[/btn_url]<br /><br /><br />
<p>----------------------------------------------------------------------<br />※こちらのアドレス[&nbsp;<a href="mailto:info@mobilesuica.com">shop@at-ec-dev.jp</a>&nbsp;]は発信専用となっております。<br />本メールは【いきもの商店くすくす】より自動配信されております。<br />本メールにご返信いただきましても対応いたしかねますのでご了承ください。<br />----------------------------------------------------------------------</p>',
            'variables' => serialize(['customer_name', 'password_reset_url']),
        ];

        $systemEmails[] = [
            'type' => 'admin.forget-password',
            'type_label' => 'Admin forgot password',
            'sender_name' => 'いきもの商店くすくす',
            'sender_email' => 'admin@at-ec-dev.jp',
            'subject' => '【アジアンテイブル】管理者パスワード再設定',
            'content' => '{user_name} 様<br /><br /> パスワードを再発行についてお知らせいたします。下記のボタンをクリックしていただき、新しいパスワードの設定をお願いいたします。<br /><br /><br /> [btn_url={password_reset_url}]パスワード再設定[/btn_url]<br /><br /><br /> このパスワード再設定のリンクは60分で期限切れになります。<br /> ボタンがうまく動作しない場合は下記のURLをコピーしてご利用ください。<br /> <a href="{password_reset_url}">{password_reset_url}</a><br /><br /><br /> -----------------------------------------------------------------------------------------<br /> 本メールは、配信専用のアドレスで配信されています。このメールにご返信 いただいても、内容の確認およびご返答はできません。ご了承ください。<br /><br /> 当サイトへの登録をした覚えがないのに、このメールを受け取られた方は、お手数ではございますがこのまま破棄をお願い致します。<br /> -----------------------------------------------------------------------------------------',
            'variables' => serialize(['user_name', 'password_reset_url']),
        ];

        $systemEmails[] = [
            'type' => 'customer.registration',
            'type_label' => 'Customer Registration',
            'sender_name' => 'いきもの商店くすくす',
            'sender_email' => 'shop@at-ec-dev.jp',
            'subject' => '【くすくす】会員登録ありがとうございます',
            'content' => '{customer_name} 様<br /><br />この度は、【いきもの商店くすくす】会員にご登録いただき、<br />誠にありがとうございます。<br /><span style="font-family: Osaka-等幅, \'ＭＳ ゴシック\', monospace; font-size: 12px;"><br /></span>お客様の登録が完了いたしましたのでご連絡申し上げます。<br /><br />----------------------------------------------------------------------<br />※こちらのアドレス[&nbsp;<a href="mailto:info@mobilesuica.com">shop@at-ec-dev.jp</a>&nbsp;]は発信専用となっております。<br />本メールは【いきもの商店くすくす】より自動配信されております。<br />本メールにご返信いただきましても対応いたしかねますのでご了承ください。<br />----------------------------------------------------------------------',
            'variables' => serialize(['customer_name']),
        ];

        $systemEmails[] = [
            'type' => 'customer.subscription-email',
            'type_label' => 'Newsletter subscription confirmation',
            'sender_name' => 'Reptile',
            'sender_email' => 'shop@at-ec-dev.jp',
            'subject' => 'Reptile - Subscription Email',
            'content' => 'Welcome to Reptile - Email Subscription<br /><br /> Thanks for putting me into your inbox. It&rsquo;s been a while since you&rsquo;ve read Bagisto email, and we don&rsquo;t want to overwhelm your inbox. If you still do not want to receive the latest email marketing news then for sure click the button below.<br /><br /><br />[btn_url={unsubscribe_url}]Unsubscribe[/btn_url]',
            'variables' => serialize(['unsubscribe_url']),
        ];

        $systemEmails[] = [
            'type' => 'order.new-order-intimation-customer',
            'type_label' => 'Customer New Order',
            'sender_name' => 'Reptile',
            'sender_email' => 'shop@at-ec-dev.jp',
            'subject' => 'New Order Reptile',
            'content' => 'Hello<br /><br />Customer Name: {customer_name}<br /><br />Order Number: {order_number}<br /><br />Order Date Time: {order_date_time}<br /><br />Shipping Address:<br />{shipping_address}<br /><br />Billing Address:<br />{billing_address}<br /><br />Shipping Method: {shipping_method}<br /><br />Payment Method: {payment_method}<br /><br />Sub Total: {sub_total_amount}<br /><br />Shipping Amount: {shipping_amount}<br /><br />Tax: {tax_amount}<br /><br />Grand Total: {grand_total_amount}<br /><br />Order Details:<br />{order_details}<br /><br />here goes some other texts',
            'variables' => serialize(['customer_name', 'order_number', 'order_date_time', 'shipping_address', 'billing_address', 'shipping_method', 'payment_method', 'order_details', 'sub_total_amount', 'shipping_amount', 'tax_amount', 'discount_amount', 'grand_total_amount']),
        ];

        $systemEmails[] = [
            'type' => 'order.new-order-intimation-admin',
            'type_label' => 'Admin New Order',
            'sender_name' => 'Reptile',
            'sender_email' => 'shop@at-ec-dev.jp',
            'subject' => 'New Order Reptile',
            'content' => 'Hello Admin,<br /><br />Customer Name: {customer_name}<br /><br />Order Number: {order_number}<br /><br />Order Date Time: {order_date_time}<br /><br />Shipping Address:<br />{shipping_address}<br /><br />Billing Address:<br />{billing_address}<br /><br />Shipping Method: {shipping_method}<br /><br />Payment Method: {payment_method}<br /><br />Sub Total: {sub_total_amount}<br /><br />Shipping Amount: {shipping_amount}<br /><br />Tax: {tax_amount}<br /><br />Grand Total: {grand_total_amount}<br /><br />Order Details:<br />{order_details}<br /><br />here goes some other texts',
            'variables' => serialize(['customer_name', 'order_number', 'order_date_time', 'shipping_address', 'billing_address', 'shipping_method', 'payment_method', 'order_details', 'sub_total_amount', 'shipping_amount', 'tax_amount', 'discount_amount', 'grand_total_amount']),
        ];

        $systemEmails[] = [
            'type' => 'order.hurry-mail',
            'type_label' => 'Hurry mail',
            'sender_name' => 'Reptile',
            'sender_email' => 'shop@at-ec-dev.jp',
            'subject' => 'Hurry mail Reptile',
            'content' => 'Hello Hurry',
            'variables' => serialize(['customer_name', 'order_number', 'order_date_time', 'shipping_address', 'billing_address', 'shipping_method', 'payment_method', 'order_details', 'sub_total_amount', 'shipping_amount', 'tax_amount', 'discount_amount', 'grand_total_amount']),
        ];

        $systemEmails[] = [
            'type' => 'order.cancel-before-payment',
            'type_label' => 'Cancel order before payment',
            'sender_name' => 'Reptile',
            'sender_email' => 'shop@at-ec-dev.jp',
            'subject' => 'Cancel order',
            'content' => 'Order cancelled before payment<br /><br />Hello<br /><br />Customer Name: {customer_name}<br /><br />Order Number: {order_number}<br /><br />Order Date Time: {order_date_time}<br /><br />Shipping Address:<br />{shipping_address}<br /><br />Billing Address:<br />{billing_address}<br /><br />Shipping Method: {shipping_method}<br /><br />Payment Method: {payment_method}<br /><br />Sub Total: {sub_total_amount}<br /><br />Shipping Amount: {shipping_amount}<br /><br />Tax: {tax_amount}<br /><br />Grand Total: {grand_total_amount}<br /><br />Order Details:<br />{order_details}<br /><br />here goes some other texts',
            'variables' => serialize(['customer_name', 'order_number', 'order_date_time', 'shipping_address', 'billing_address', 'shipping_method', 'payment_method', 'order_details', 'sub_total_amount', 'shipping_amount', 'tax_amount', 'discount_amount', 'grand_total_amount']),
        ];

        $systemEmails[] = [
            'type' => 'order.cancel-after-payment',
            'type_label' => 'Cancel order after payment',
            'sender_name' => 'Reptile',
            'sender_email' => 'shop@at-ec-dev.jp',
            'subject' => 'Cancel order',
            'content' => 'Order cancelled after payment<br /><br />Hello<br /><br />Customer Name: {customer_name}<br /><br />Order Number: {order_number}<br /><br />Order Date Time: {order_date_time}<br /><br />Shipping Address:<br />{shipping_address}<br /><br />Billing Address:<br />{billing_address}<br /><br />Shipping Method: {shipping_method}<br /><br />Payment Method: {payment_method}<br /><br />Sub Total: {sub_total_amount}<br /><br />Shipping Amount: {shipping_amount}<br /><br />Tax: {tax_amount}<br /><br />Grand Total: {grand_total_amount}<br /><br />Order Details:<br />{order_details}<br /><br />here goes some other texts',
            'variables' => serialize(['customer_name', 'order_number', 'order_date_time', 'shipping_address', 'billing_address', 'shipping_method', 'payment_method', 'order_details', 'sub_total_amount', 'shipping_amount', 'tax_amount', 'discount_amount', 'grand_total_amount']),
        ];

        $systemEmails[] = [
            'type' => 'order.invoice',
            'type_label' => 'Payment & Order Confirmation',
            'sender_name' => 'Reptile',
            'sender_email' => 'shop@at-ec-dev.jp',
            'subject' => 'Payment & Order Confirmation',
            'content' => 'Invoice generated<br /><br />Hello<br /><br />Customer Name: {customer_name}<br /><br />Order Number: {order_number}<br /><br />Order Date Time: {order_date_time}<br /><br />Shipping Address:<br />{shipping_address}<br /><br />Billing Address:<br />{billing_address}<br /><br />Shipping Method: {shipping_method}<br /><br />Payment Method: {payment_method}<br /><br />Sub Total: {invoice_sub_total_amount}<br /><br />Shipping Amount: {invoice_shipping_amount}<br /><br />Tax: {invoice_tax_amount}<br /><br />Grand Total: {invoice_grand_total_amount}<br /><br />Invoice number: {invoice_number}<br /><br />Invoice Details:<br />{invoice_details}<br /><br />here goes some other texts',
            'variables' => serialize(['customer_name', 'order_number', 'order_date_time', 'shipping_address', 'billing_address', 'shipping_method', 'payment_method', 'invoice_number', 'invoice_details', 'invoice_sub_total_amount', 'invoice_shipping_amount', 'invoice_tax_amount', 'invoice_discount_amount', 'invoice_grand_total_amount']),
        ];

        $systemEmails[] = [
            'type' => 'order.shipped',
            'type_label' => 'Order Shipped',
            'sender_name' => 'Reptile',
            'sender_email' => 'shop@at-ec-dev.jp',
            'subject' => 'Order Shipped',
            'content' => 'Order Shipped<br /><br />Hello<br /><br />Customer Name: {customer_name}<br /><br />Order Number: {order_number}<br /><br />Order Date Time: {order_date_time}<br /><br />Shipping Address:<br />{shipping_address}<br /><br />Billing Address:<br />{billing_address}<br /><br />Shipping Method: {shipping_method}<br /><br />Payment Method: {payment_method}<br /><br />Shipment Carrier: {shipment_carrier}<br /><br />Tracking Number: {shipment_tracking_number}<br /><br />Shipment Details<br /> {shipment_details}<br /><br /><br />here goes some other texts',
            'variables' => serialize(['customer_name', 'order_number', 'order_date_time', 'shipping_address', 'billing_address', 'shipping_method', 'payment_method', 'shipment_carrier', 'shipment_tracking_number', 'shipment_details']),
        ];

        $systemEmails[] = [
            'type' => 'order.refunded',
            'type_label' => 'Refunded',
            'sender_name' => 'Reptile',
            'sender_email' => 'shop@at-ec-dev.jp',
            'subject' => 'Refunded',
            'content' => 'Refunded<br /><br />Hello<br /><br />Customer Name: {customer_name}<br /><br />Order Number: {order_number}<br /><br />Order Date Time: {order_date_time}<br /><br />Shipping Address:<br />{shipping_address}<br /><br />Billing Address:<br />{billing_address}<br /><br />Shipping Method: {shipping_method}<br /><br />Payment Method: {payment_method}<br /><br />Sub Total: {refund_sub_total_amount}<br /><br />Shipping Amount: {refund_shipping_amount}<br /><br />Tax: {refund_tax_amount}<br /><br />Adjustment: {refund_adjustment_amount}<br /><br />Adjustment Fee: {refund_adjustment_fee_amount}<br /><br />Grand Total: {refund_grand_total_amount}<br /><br />Refund Details<br /> {refund_details}<br /><br /><br />here goes some other texts',
            'variables' => serialize(['customer_name', 'order_number', 'order_date_time', 'shipping_address', 'billing_address', 'shipping_method', 'payment_method', 'refund_details', 'refund_sub_total_amount', 'refund_shipping_amount', 'refund_tax_amount', 'refund_discount_amount', 'refund_adjustment_amount', 'refund_adjustment_fee_amount', 'refund_grand_total_amount']),
        ];

        foreach ($systemEmails as $systemEmail) {
            $email = DB::table('system_emails')->where('type', $systemEmail['type'])->first();

            if (!$email) {
                DB::table('system_emails')->insert($systemEmail);
            }

        }
    }
}