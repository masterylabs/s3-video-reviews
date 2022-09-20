const videoAspectRatiosForm = {
  value: 'aspectRatio',
  text: 'Aspect Ratio',
  items: [
    {
      text: 'auto',
      value: 'auto',
    },
    {
      text: '16:9 (standard)',
      value: '16 / 9',
      calc: 16 / 9,
    },
    {
      text: '9:16 (shorts / portrait)',
      value: '9 / 16',
      calc: 9 / 16,
    },
    {
      text: '4:3 old school',
      value: '4 / 3',
      calc: 4 / 3,
    },
    {
      text: '1.85:1 widescreen',
      value: '1.85 / 1',
      calc: 1.85 / 1,
    },
    {
      text: 'anamorphic 2.39:1 widescreen',
      value: '2.39 / 1',
      calc: 2.39 / 1,
    },
  ],
}

export {
  //
  videoAspectRatiosForm,
}
