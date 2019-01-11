export default function getPageId() {
	let pageID = '';
	let list = document.getElementsByTagName('body')[0].classList;

	for (let i = 0; i < list.length; i++) {
		if (list[i].indexOf('page-id') !== -1) {
			pageID = list[i].slice(8);
		}
	}

	return pageID;
}
