import $ from 'jquery';
import debug from 'debug';

export function emptyLinks() {
	const log   = debug('theme:emptyLinks');
	const links = $('a[href=""], a[href="#"]').toArray();
	log(`There are ${links.length} empty links on this page`, links);
}

export function externalLinks() {
	const log    = debug('theme:externalLinks');
	const $links = $('a[href]:not([target])').filter((i, link) => {
		const href     = $(link).attr('href').trim();
		const isEmpty  = href === '';
		const isLocal  = href.indexOf(document.location.origin) === 0;
		const isAnchor = href.indexOf('#') === 0;

		if (isEmpty || isLocal || isAnchor) {
			return false;
		}

		return true;
	});

	$links.attr('target', '_blank');
	log(`There are ${$links.length} external links on this page`, $links);
}

export default {
	emptyLinks   : emptyLinks,
	externalLinks: externalLinks
};