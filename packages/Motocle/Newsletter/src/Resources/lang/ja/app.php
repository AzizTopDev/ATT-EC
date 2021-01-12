<?php

return [
    'cms' => [
        'newsletter' => [
            'newsletter' => 'メール配信',
            'newsletter-edit' => 'メールテンプレート編集',
            'templates' => 'テンプレート',
            'history' => '送信履歴',
            'sent_date' => '送信日',
            'template-name' => 'アドミン名称',
            'subject' => 'メールタイトル',
            'mail_content' => 'メール内容',
            'created_at' => '作成日',
            'last_updated_at' => '最終更新日',
            'count' => '送信件数',
            'test_email_address' => 'テスト送信用メールアドレス',
            'add-newsletter-button' => '新規追加',
            'save_button' => '保存',
            'test_send_button' => 'テスト送信',
            'send_button' => '購読者にメール送信',
            'save_template_success' => 'このメールは正常に保存されました',
            'test_email_success' => 'テストメールを送りました',
            'test_email_failure' => 'もう一回試してください',
            'send_success' => 'このメールは正常に送ることができました',
            'send_failure' => 'もう一回試してください',
            'confirm_delete' => 'このテンプレートを削除してもよろしいですか？',
            'delete_template_success' => 'テンプレートは正常に削除されました。',
            'delete_template_failure' => 'もう一回試してください',

            'page-title' => [
                'create' => 'メールテンプレートの作成',
            ],

            'validation' => [
                'name' => [
                    'required' => 'アドミン名称 を入力してください。',
                    'unique' => 'アドミン名称はすでに存在しています。',
                ],
                'subject' => [
                    'required' => 'メールタイトル を入力してください。',
                ],
                'content' => [
                    'required' => 'メール内容 を入力してください。',
                ],
                'email' => [
                    'required' => 'メールアドレス を入力してください。',
                    'email' => '無効なメールアドレス',
                ]
            ]
        ],
    ],
];
