const getSmallestIndex = (a) => {
	var lowest = 0
	for (var i = 1; i < a.length; i++) {
		if (a[i] < a[lowest]) lowest = i
	}
	return lowest
}

const getShortest = (items) => {
	const values = []

	// get smallest col
	items.forEach((col, i) => {
		let heights = col.map((a) => a.height)
		let h = heights.reduce((a, b) => a + b, 0)

		values.push(h)
	})

	const index = getSmallestIndex(values)

	return index
}

const imageGrid = (items, colsNumber = 4) => {
	if (typeof colsNumber != 'number') colsNumber = parseInt(colsNumber)

	const cols = []
	for (let i = 0; i < colsNumber; i++) {
		if (this.items.length <= i) break
		cols[i] = []
	}

	items.forEach((item) => {
		const index = getShortest(cols)
		cols[index].unshift(item)
	})

	return cols
}

export default imageGrid
