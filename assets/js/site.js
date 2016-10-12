// external scripts
import $ from 'jquery';
import debug from 'bows';

// example of ES2015 modules loading & tree shaking
import { emptyLinks } from './_links';

const $window   = $(window);
const $document = $(document);
const log       = debug('site');

class Site {
	constructor() {
		$document.ready(() => this.domReady());
		$window.on('load', () => this.windowLoad());
	}

	domReady() {
		const log = debug('site:domReady');
		log('dom.ready');
	}

	windowLoad() {
		const log = debug('site:windowLoad');
		log('window.onload');

		// example of ES2015 modules loading & tree shaking
		emptyLinks();
	}
}

export default Site;
