export const messages = {
    required: field => `${field.replace(/[\[\]"]+/g, '')}を入力してください。`,
    numeric: field => `${field.replace(/[\[\]"]+/g, '')}は数字のみご入力ください。`,
    decimal: field => `${field.replace(/[\[\]"]+/g, '')}は数字のみご入力ください。`,
    email: email => '正しいメールアドレスの形式で入力してください。',
    min: password => 'パスワードの長さは6文字以上必要です。',
    confirmed: password_confirmation => '新パスワードを再入力パスワードが一致しません。'
}