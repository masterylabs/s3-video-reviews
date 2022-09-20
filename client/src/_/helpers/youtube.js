export const ytPlayerStates = [
  // -1: unstarted
  'ended', // 0
  'playing',
  'paused',
  'paused',
  'buffering',
  '', // nothing
  'cued', // ready
]

export const ytGetPlayerState = (index) => {
  if (index < 0) return 'unstarted'
  return ytPlayerStates[index]
}
