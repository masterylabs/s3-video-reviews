const currencies = [
  {
    text: 'Australian Dollar',
    value: 'AUD',
    code: '$',
  },
  {
    text: 'Brazilian Real',
    value: 'BRL',
    code: 'R$',
  },
  {
    text: 'Canadian Dollar',
    value: 'CAD',
    code: '$',
  },
  {
    text: 'Chinese Yuan',
    value: 'CNY',
    code: '¥ /元',
  },
  {
    text: 'Czech Koruna',
    value: 'CZK',
    code: '	Kč',
  },
  {
    text: 'Danish Krone',
    value: 'DKK',
    code: 'kr',
  },
  {
    text: 'Euro',
    value: 'EUR',
    code: '€',
  },
  {
    text: 'Hong Kong Dollar',
    value: 'HKD',
    code: '$',
  },
  {
    text: 'Hungarian Forint',
    value: 'HUF',
    code: 'Ft',
  },
  {
    text: 'Indian Rupee',
    value: 'INR',
    code: '	₹',
  },
  {
    text: 'Israeli New Shekel',
    value: 'ILS',
    code: '₪', //'ILS',
  },
  {
    text: 'Japanese Yen',
    value: 'JPY',
    code: '¥',
  },
  {
    text: 'Malaysian Ringgit',
    value: 'MYR',
    code: 'RM',
  },
  {
    text: 'Mexican Peso',
    value: 'MXN',
    code: '$',
  },
  {
    text: 'New Taiwan Dollar',
    value: 'TWD',
    code: '$',
  },
  {
    text: 'New Zealand Dollar',
    value: 'NZD',
    code: '$',
  },
  {
    text: 'Norwegian Krone',
    value: 'NOK',
    code: 'kr',
  },
  {
    text: 'Philippine Peso',
    value: 'PHP',
    code: '₱',
  },
  {
    text: 'Polish Złoty',
    value: 'PLN',
    code: 'zł',
  },
  {
    text: 'Pound Sterling',
    value: 'GBP',
    code: '£',
  },
  {
    text: 'Russian Ruble',
    value: 'RUB',
    code: '₽',
  },
  {
    text: 'Singapore Dollar',
    value: 'SGD',
    code: '$',
  },
  {
    text: 'Swedish Krona',
    value: 'SEK',
    code: '	kr',
  },
  {
    text: 'Swiss Franc',
    value: 'CHF',
    code: 'CHF',
  },
  {
    text: 'Thai Baht',
    value: 'THB',
    code: '฿',
  },
  {
    text: 'United States Dollar',
    value: 'USD',
    code: '$',
  },
]

export default currencies

export const getCurrencyCode = (v = 'USD') => {
  let value
  currencies.forEach((item) => {
    if (!value && item.value == v) value = item.code
  })

  return value
}
