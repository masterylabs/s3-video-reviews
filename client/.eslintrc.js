module.exports = {
  root: true,
  env: {
    node: true,
  },
  extends: ['plugin:vue/essential', 'eslint:recommended'],
  parserOptions: {
    parser: 'babel-eslint',
  },
  rules: {
    'no-console': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
    'no-debugger': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
    'no-unused-vars': 'warn',
    'no-empty': 'warn',
    'no-unreachable': 'warn',
    'no-undef': 'warn',
    'vue/no-unused-vars': 'warn',
    'getter-return': 'warn',
    'no-cond-assign': 'warn',
    'no-prototype-builtins': 'warn',
  },
}
