// external scripts
import $ from 'jquery';
import debug from 'debug';

// example of ES2015 modules loading & tree shaking
import { emptyLinks } from './links';

const $window   = $(window);
const $document = $(document);

class Site {
	constructor() {
		$document.ready(() => this.domReady());
		$window.on('load', () => this.windowLoad());
	}

	domReady() {
		const log = debug('theme:domReady');
		log('dom.ready');
	}

	windowLoad() {
		const log = debug('theme:windowLoad');
		log('window.onload');

		// example of ES2015 modules loading & tree shaking
		emptyLinks();
	}
}

export default Site;
