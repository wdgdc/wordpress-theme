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
			sass  : '<%= project.assets %>/sass',
			stylus: '<%= project.assets %>/stylus',
			vendor: '<%= project.assets %>/vendor'
		},

		// Watches for changes and runs tasks
		watch: {
			options: {
				livereload: true,
				spawn     : false
			},
			// sass: {
			// 	files: ['<%= project.sass %>/**/*.scss'],
			// 	tasks: ['sass', 'autoprefixer', 'modernizr']
			// },
			// stylus: {
			// 	files: ['<%= project.stylus %>/**/*.styl'],
			// 	tasks: ['stylus', 'autoprefixer', 'modernizr']
			// },
			// less: {
			// 	files: ['<%= project.less %>/**/*.less'],
			// 	tasks: ['less', 'autoprefixer', 'modernizr']
			// },
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
				files: ['<%= project.root %>/**/*.php']
			}
		},

		// CSS auto prefixer
		autoprefixer: {
			all: {
				expand : true,
				flatten: true,
				src    : '<%= project.css %>/**/*.css',
				dest   : '<%= project.css %>'
			}
		},

		// Javascript Linter
		jshint: {
			all: {
				src: ['<%= project.js %>/**/*.js', '!**/*.min.js']
			},
			options: {
				jshintrc: true
			}
		},

		// Image compression
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

		// Sass (Scss) compilation
		// $ npm install grunt-sass --save-dev
		// create directory /assets/sass
		sass: {
			all: {
				files: [{
					expand: true,
					cwd: '<%= project.sass %>',
					src: ['**/*.scss', '!**/_*.scss'],
					dest: '<%= project.css %>',
					ext: '.css'
				}],

				// grunt-contrib-sass
				// options: {
				// 	loadPath: require('node-bourbon').includePaths,
				// 	quiet: true,
				// 	style: 'expanded'
				// }

				// grunt-sass
				options: {
					// $ npm install node-bourbon --save-dev
					// $ bower install foundation --save
					// includePaths: [
					// 	require('node-bourbon').includePaths,
					// 	'<%= project.vendor %>/foundation/scss'
					// ],
					quiet: true,
					outputStyle: 'expanded'
				}
			}
		},

		// Stylus compilation (requires to install grunt-contrib-stylus)
		// $ npm install grunt-contrib-stylus --save-dev
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

		// Less compilation (requires to install grunt-contrib-less)
		// $ npm install grunt-contrib-less --save-dev
		less: {
			all: {
				files: [{
					expand: true,
					cwd : '<%= project.less %>',
					src : ['**/*.less', '!**/_*.less'],
					dest: '<%= project.css %>',
					ext : '.css'
				}],
				options: {
					compress: false
				}
			}
		},

		// Generates a custom modernizr file based on CSS & JS usage
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
	});


	// Load up tasks
	grunt.loadNpmTasks('grunt-autoprefixer');
	grunt.loadNpmTasks('grunt-contrib-imagemin');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-modernizr');


	// Optional tasks
	// grunt.loadNpmTasks('grunt-sass');
	// grunt.loadNpmTasks('grunt-contrib-stylus');
	// grunt.loadNpmTasks('grunt-contrib-less');


	// Default task
	grunt.registerTask('default', ['watch']);


	// Build task
	grunt.registerTask('build', ['autoprefixer', 'modernizr', 'imagemin']);
	// grunt.registerTask('build', ['sass', 'autoprefixer', 'modernizr', 'imagemin']);
	// grunt.registerTask('build', ['stylus', 'autoprefixer', 'modernizr', 'imagemin']);
	// grunt.registerTask('build', ['less', 'autoprefixer', 'modernizr', 'imagemin']);
};
