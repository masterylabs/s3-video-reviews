export default {
  data() {
    return {
      tickerRunning: false,
      ticker: null,
      tickerTime: 300,
    }
  },

  methods: {
    startTicker() {
      if (this.tickerRunning) return

      this.tickerRunning = true

      this.ticker = setInterval(() => {
        // player no longer existings
        if (!this.player) return this.stopTicker()

        this.player.onTicker()
      }, this.tickerTime)
    },
    stopTicker() {
      clearInterval(this.ticker)
      this.tickerRunning = false
      this.tickerGettingTime = false
    },
  },
}
