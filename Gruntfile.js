module.exports = function(grunt) {

	grunt.initConfig({

		// Run watch and shell in parallel
		concurrent: {
			all: {
				tasks: ['watch', 'shell'],
				options: {
					logConcurrentOutput: true
				}
			}
		},

		// Watches for changes and runs tasks
		watch: {
			options: {
				livereload: true
			},
			stylesheets: {
				files  : ['library/css/**/*.css']
			},
			scripts: {
				files  : ['library/js/**/*.js'],
				tasks  : ['jshint']
			},
			php: {
				files  : ['**/*.php']
			}
		},

		// JsHint your javascript
		jshint: {
			all    : ['library/js/*.js'],
			options: {
				browser  : true,
				curly    : false,
				eqeqeq   : false,
				eqnull   : true,
				expr     : true,
				immed    : true,
				newcap   : true,
				noarg    : true,
				smarttabs: true,
				sub      : true,
				undef    : false
			}
		},

		// Image min
		imagemin: {
			production: {
				files: [{
					expand: true,
					cwd: 'library/images',
					src: '**/*.{png,jpg,jpeg}',
					dest: 'library/images'
				}]
			}
		},

		// SVG min
		svgmin: {
			production: {
				files: [{
					expand: true,
					cwd   : 'library/images',
					src   : '**/*.svg',
					dest  : 'library/images'
				}]
			}
		},

		// Dev and production build for stylus
		stylus: {
			all: {
				files: [{
					src : ['library/stylus/**/*.styl', '!**/_*.styl'],
					dest: 'library/css'
				}]
			},
			production: {
				options: {
					compress: true
				}
			},
			dev: {
				options: {
					compress: false
				}
			}
		},

		// Shell
		shell: {
			stylus: {
				command: function() {
					var filesConfig = grunt.config('stylus.all.files');
					var files       = [];
					var out         = '';
					var include     = '';

					filesConfig.forEach(function(file) {
						files = files.concat(grunt.file.expand(file.src));
						out   = '--out ' + file.dest;
						include = file.cwd;
					});

					var compress = grunt.config('stylus.dev.options.compress') ? '--compress' : '';
					var cmd      = 'node node_modules/stylus/bin/stylus --use nib --watch ' + [compress, out, files.join(' ')].join(' ');

					return cmd;
				},
				options: {
					failOnError: true,
					stdout: true,
					sterr: true
				}
			}
		}
	});


	// Load up tasks
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-imagemin');
	grunt.loadNpmTasks('grunt-svgmin');
	grunt.loadNpmTasks('grunt-shell');
	grunt.loadNpmTasks('grunt-concurrent');


	// Run bower install
	grunt.registerTask('bower-install', function() {
		var done  = this.async();
		var bower = require('bower').commands;
		bower.install().on('end', function(data) {
			done();
		}).on('data', function(data) {
			console.log(data);
		}).on('error', function(err) {
			console.error(err);
			done();
		});
	});


	// Default task
	grunt.registerTask('default', ['concurrent']);

	// Build task
	grunt.registerTask('build', ['jshint', 'stylus:production', 'imagemin:production', 'svgmin:production']);

	// Template Setup Task
	grunt.registerTask('setup', ['stylus:dev', 'bower-install']);

};
