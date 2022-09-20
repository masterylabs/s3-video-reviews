export default {
  async onVideoPoster({ commit, dispatch, state: { data } }, value) {
    // video posters
    const videoPosters =
      data.meta && data.meta.videoPosters ? [...data.meta.videoPosters] : []

    const index = videoPosters.findIndex(({ Key }) => Key === value.Key)

    if (index < 0) {
      videoPosters.push(value)
    } else {
      videoPosters[index] = value
    }

    commit('SET_META', { videoPosters })

    // bg save
    await dispatch('updateItem')
  },
}
