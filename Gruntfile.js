/* global __dirname, module, require */

module.exports = function(grunt) {

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		project: {
			assets: '<%= project.root %>/assets',
			dist  : '<%= project.assets %>/dist',
			fonts : '<%= project.assets %>/fonts',
			img   : '<%= project.assets %>/img',
			inc   : '<%= project.root %>/includes',
			js    : '<%= project.assets %>/js',
			lang  : '<%= project.root %>/languages',
			root  : __dirname,
			sass  : '<%= project.assets %>/sass',
			vendor: '<%= project.assets %>/vendor'
		},

		// Watches for changes and runs tasks
		watch: {
			options: {
				livereload: true,
				spawn     : false
			},
			sass: {
				files: ['<%= project.sass %>/**/*.scss'],
				tasks: [
					'sass_globbing',
					'sass',
					'autoprefixer',
					'modernizr'
				]
			},
			css: {
				files: ['<%= project.dist %>/**/*.css'],
				tasks: [
					'autoprefixer',
					'modernizr'
				]
			},
			img: {
				files: ['<%= project.img %>/**/*.{png,jpg,jpeg,gif,svg}'],
				tasks: ['newer:imagemin']
			},
			js: {
				files: ['<%= project.js %>/**/*.js'],
				tasks: [
					'modernizr',
					'lodashAutobuild',
					'babel'
					// 'jshint'
				]
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
				src    : '<%= project.dist %>/**/*.css',
				dest   : '<%= project.dist %>'
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

		babel: {
			options: {
				sourceMap: true,
				presets: ['es2015']
			},
			all: {
				files: [{
					expand: true,
					cwd: '<%= project.js %>',
					src: ['**/*.js'],
					dest: '<%= project.dist %>',
					ext: '.js'
				}]
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
					dest: '<%= project.dist %>',
					ext: '.css'
				}],

				// bourbon with neat
				options: {
					includePaths: require('node-neat').includePaths,
					quiet: true,
					outputStyle: 'expanded'
				}

				// bourbon without neat
				// options: {
				// 	includePaths: [require('node-bourbon').includePaths],
				// 	quiet: true,
				// 	outputStyle: 'expanded'
				// },
			}
		},

		// Sass Globbing
		sass_globbing: {
			all: {
				files: {
					'<%= project.sass %>/_components.scss':'<%= project.sass %>/components/**/*.scss',
					'<%= project.sass %>/_mixins.scss':'<%= project.sass %>/mixins/**/*.scss',
					'<%= project.sass %>/_variables.scss':'<%= project.sass %>/variables/**/*.scss'
				}
			}
		},

		// Generates a custom modernizr file based on CSS & JS usage
		modernizr: {
			all: {
				cache: true,
				dest: '<%= project.dist %>/modernizr.js',
				options: [
					'setClasses',
					'addTest',
					'html5printshiv',
					'testProp',
					'fnBind'
				],
				uglify: true,
				crawl: true,
				files: {
					src: ['<%= project.dist %>/**/*.css', '<%= project.js %>/**/*.js']
				}
			}
		},

		lodash: {
			build: {
				dest: '<%= project.dist %>/lodash.js',
				options: {
					'modifier':'compat'
				}
			}
		},

		// Generates a custom lodash file based on CSS & JS usage
		lodashAutobuild: {
			all: {
				src: ['<%= project.js %>/**/*.js'],
				options: {
		          // Set to the configured lodash task options.include
		          lodashConfigPath: 'lodash.all.options.include',
		          // The name(s) of the lodash object(s)
		          lodashObjects: [ '_' ],
		          // Undefined lodashTargets or an empty targets
		          // array will run all lodash targets. Specify
		          // targets by name to run specific targets
		          lodashTargets: [ 'build' ]
		        }
			}
		}
	});


	// Load up tasks
	grunt.loadNpmTasks('grunt-autoprefixer');
	grunt.loadNpmTasks('grunt-contrib-imagemin');
	// grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-modernizr');
	grunt.loadNpmTasks('grunt-sass-globbing');
	grunt.loadNpmTasks('grunt-sass');
	grunt.loadNpmTasks('grunt-lodash');
	grunt.loadNpmTasks('grunt-lodash-autobuild');
	grunt.loadNpmTasks('grunt-babel');

	// Optional tasks


	// Default task
	grunt.registerTask('default', ['build', 'watch']);


	// Build task
	grunt.registerTask('build', [
		'sass_globbing',
		'sass',
		'autoprefixer',
		'modernizr',
		'imagemin',
		'lodashAutobuild',
		// 'jshint',
		'babel'
	]);
};
