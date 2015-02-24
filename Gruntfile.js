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
				tasks: ['sass_globbing', 'sass', 'autoprefixer', 'modernizr']
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

				// grunt-sass
				options: {
					includePaths: [
						require('node-bourbon').includePaths,
						// $ bower install foundation --save
						//'<%= project.vendor %>/foundation/scss'
					],
					quiet: true,
					outputStyle: 'expanded'
				}
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
				devFile: '<%= project.vendor %>/modernizr/modernizr.js',
				outputFile: '<%= project.vendor %>/modernizr/modernizr-custom.js',
				extensibility: {
					domprefixes: true,
					prefixes   : true
				},
				matchCommunityTests: true,
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
	grunt.loadNpmTasks('grunt-sass-globbing');
	grunt.loadNpmTasks('grunt-sass');

	// Optional tasks


	// Default task
	grunt.registerTask('default', ['build', 'watch']);


	// Build task
	grunt.registerTask('build', ['sass_globbing', 'sass', 'autoprefixer', 'modernizr', 'imagemin']);
};