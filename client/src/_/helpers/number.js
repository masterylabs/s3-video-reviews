export const bigNumber = (n) => {
	if (!n) return 0
	if (n < 999) return n
	return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',')
}
