const deepMerge = (t, s) => {
  const o = Object,
    a = o.assign
  for (const k of o.keys(s)) s[k] instanceof o && a(s[k], deepMerge(t[k], s[k]))
  return a(t || {}, s), t
}

export default deepMerge
