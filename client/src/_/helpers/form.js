export const mergeForm = (form, apiForm) => {
  const items = []

  for (const value in apiForm) {
    let entry = {
      text: apiForm[value],
      value,
    }

    if (form[value]) entry = { ...entry, ...form[value] }

    items.push(form)
  }

  // validate all added

  return items
}
