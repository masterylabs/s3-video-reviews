const noAddons = (data) => {
  if (!data.integrations || !data.integrations.length) return true
  if (!data.license || !data.license.addons || !data.license.addons.length)
    return true
  return false
}

const getters = {
  hasAddon({ data }) {
    if (noAddons(data)) return {}

    const hasAddon = {}
    const licenseAddons = data.license.addons.map((a) => a.app_id)


    // only add valid addons
    licenseAddons.forEach((k) => {
      if (data.integrations.indexOf(k) > -1) hasAddon[k] = true
    })

    return hasAddon
  },

  addons({ data }) {
    if (noAddons(data)) return {}

    const addons = []

    // only add valid addons
    data.license.addons.forEach((addon) => {
      if (data.integrations.indexOf(addon.app_id) > -1) addons.push(addon)
    })

    return addons
  },
}

export default {
  getters,
}
