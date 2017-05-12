/**
 * this implementation of fitvid doesn't force items to 16/9.  It measures them and then keeps the ratio unique per embed
 *
 * @var selectors (string|array) additional selectors search for in the DOM
 * @return nodes - array of matched items
 */

export default function(selectors) {
	const config = {
		selectors: [
			'iframe[src*="player.vimeo.com"]',
			'iframe[src*="youtube.com"]',
			'iframe[src*="youtube-nocookie.com"]',
			'object',
			'embed'
		]
	};

	if ( selectors ) {
		if ( !Array.isArray(selectors) ) {
			selectors = [selectors];
		}
		config.selectors = config.selectors.concat(opts.selectors).filter(( val, index, arr ) => arr.indexOf(val) === index );
	}

	const nodes = Array.prototype.slice.call( document.querySelectorAll( config.selectors.join(',') ) );

	if ( nodes.length > 0 ) {
		nodes.forEach((node) => {
			if ( node.getAttribute('data-fitvid' ) ) {
				return;
			}
			const wrapper = document.createElement('div');
			const computed = window.getComputedStyle(node);
			const ratio = ( (computed.height > 0 && computed.width > 0) ? computed.height / computed.width : 9 / 16 ) * 100;

			wrapper.className = 'fitvid';
			wrapper.style.width = '100%';
			wrapper.style.height = 0;
			wrapper.style.position = 'relative';
			wrapper.style.paddingTop = `${ratio}%`;

			node.style.position = 'absolute';
			node.style.top = 0;
			node.style.left = 0;
			node.style.width = '100%';
			node.style.height = '100%';
			node.setAttribute('data-fitvid', ratio);
			node.parentNode.insertBefore(wrapper, node);

			wrapper.appendChild(node);
		});
	}

	return nodes;
}
