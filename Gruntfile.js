module.exports = function(grunt) {

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		project: {
			assets: '<%= project.root %>/assets',
			css   : '<%= project.assets %>/css',
			fonts : '<%= project.assets %>/fonts',
			img   : '<%= project.assets %>/img',
			inc   : '<%= project.root %>/includes',
			js    : '<%= project.assets %>/js',
			lang  : '<%= project.root %>/languages',
			less  : '<%= project.assets %>/less',
			root  : __dirname,
			sass  : '<%= project.assets %>/scss',
			stylus: '<%= project.assets %>/stylus',
			vendor: '<%= project.assets %>/vendor'
		},

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
				livereload: true,
				spawn     : false
			},
			less: {
				files: ['<%= project.less %>/**/*.less'],
				tasks: ['less']
			},
			sass: {
				files: ['<%= project.sass %>/**/*.scss'],
				tasks: ['sass']
			},
			stylus: {
				files: ['<%= project.stylus %>/**/*.styl'],
				tasks: ['stylus']
			},
			css: {
				files: ['<%= project.css %>/**/*.css'],
				tasks: ['autoprefixer', 'modernizr']
			},
			img: {
				files: ['<%= project.img %>/**/*.{png,jpg,jpeg,gif,svg}'],
				tasks: ['newer:imagemin']
			},
			js: {
				files: ['<%= project.js %>/**/*.js'],
				tasks: ['jshint', 'modernizr']
			},
			php: {
				files: ['<%= project.root %>/**/*.php'],
				tasks: ['phplint']
			}
		},

		autoprefixer: {
			all: {
				expand : true,
				flatten: true,
				src    : '<%= project.css %>/**/*.css',
				dest   : '<%= project.css %>'
			}
		},

		// JSHint your javascript
		jshint: {
			all: {
				src: ['<%= project.js %>/**/*.js', '!**/*.min.js']
			},
			options: {
				jshintrc: true
			}
		},

		// Image min
		imagemin: {
			all: {
				files: [{
					expand: true,
					cwd: '<%= project.img %>',
					src: '**/*.{png,jpg,jpeg,gif,svg}',
					dest: '<%= project.img %>'
				}]
			}
		},

		// Stylus compilation
		stylus: {
			all: {
				files: [{
					expand: true,
					cwd : '<%= project.stylus %>',
					src : ['**/*.styl', '!**/_*.styl'],
					dest: '<%= project.css %>',
					ext : '.css'
				}],
				options: {
					compress: false
				}
			}
		},

		// custom modernizr
		modernizr: {
			all: {
				devFile: '<%= project.vendor %>/modernizr/modernizr.js',
				outputFile: '<%= project.vendor %>/modernizr/modernizr-custom.js',
				extensibility: {
					domprefixes: true,
					prefixes   : true
				},
				files: {
					src: ['<%= project.css %>/**/*.css', '<%= project.js %>/**/*.js']
				}
			}
		}

		// Shell
		// shell: {
		// 	stylus: {
		// 		command: function() {
		// 			var filesConfig = grunt.config('stylus.all.files');
		// 			var files       = [];
		// 			var out         = '';
		// 			var include     = '';

		// 			filesConfig.forEach(function(file) {
		// 				files = files.concat(grunt.file.expand(file.src));
		// 				out   = '--out ' + file.dest;
		// 				include = file.cwd;
		// 			});

		// 			var compress = grunt.config('stylus.dev.options.compress') ? '--compress' : '';
		// 			var cmd      = 'node node_modules/stylus/bin/stylus --use nib --watch ' + [compress, out, files.join(' ')].join(' ');

		// 			return cmd;
		// 		}
		// 	}
		// }
	});


	// Load up tasks
	// grunt.loadNpmTasks('grunt-concurrent');
	// grunt.loadNpmTasks('grunt-shell');
	// grunt.loadNpmTasks('grunt-svgmin');
	grunt.loadNpmTasks('grunt-autoprefixer');
	grunt.loadNpmTasks('grunt-contrib-imagemin');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-stylus');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-modernizr');
	grunt.loadNpmTasks('grunt-newer');


	// Run bower install
	// grunt.registerTask('bower-install', function() {
	// 	var done  = this.async();
	// 	var bower = require('bower').commands;
	// 	bower.install().on('end', function(data) {
	// 		done();
	// 	}).on('data', function(data) {
	// 		console.log(data);
	// 	}).on('error', function(err) {
	// 		console.error(err);
	// 		done();
	// 	});
	// });


	// Default task
	// grunt.registerTask('default', ['concurrent']);
	// grunt.registerTask('default', ['watch']);

	// Build task
	grunt.registerTask('build', ['stylus', 'autoprefixer', 'modernizr', 'imagemin', 'svgmin']);

	// Template Setup Task
	// grunt.registerTask('setup', ['stylus:dev', 'bower-install']);

};
