import 'magnific-popup';

export default function () {

	const linkYT = $('[href*="youtu.be"]');
	const modifedLinkYT = $('[href*="watch?v="]');
	const linkVimeo = $('[href*="vimeo"]');

	linkYT.each(function () {
		const $this = $(this),
			link = $this.attr('href'),
			newLink = link.replace('youtu.be/', 'www.youtube.com/watch?v=');

		$this.attr('href', newLink);
	});

	if (linkYT.length || modifedLinkYT.length || linkVimeo) {
		linkYT.add(modifedLinkYT).add(linkVimeo).magnificPopup({
			type: 'iframe',
			iframe: {
				patterns: {
					youtube: {
						index: 'youtube.com/',
						id: 'v=',
						src: '//www.youtube.com/embed/%id%?rel=0&autoplay=1',
					},
					vimeo: {
						index: 'vimeo.com/',
						id: '/',
						src: '//player.vimeo.com/video/%id%?autoplay=1'
					},
				},
			},
		});
	}
}
