const contactDictionary = {
    custom: {
        name: {
            required: 'アドミン名称 を入力してください。'
        },
        subject: {
            required: 'メールタイトル を入力してください。'
        },
        content: {
            required: 'メール内容 を入力してください。',
        },
        email: {
            required: 'メールアドレス を入力してください。',
            email: '無効なメールアドレス'
        },
    }
}

VeeValidate.Validator.localize('ja', contactDictionary)

$(document).ready(function () {
    $('.contact-us').on('submit', 'form', function() {
        $('html, body').animate({ scrollTop: ($('.error').eq(0).parent().offset().top)-100 }, 'slow');
    })
})
