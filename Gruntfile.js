module.exports = function(grunt) {

	// Carica i plugin

	//grunt.loadNpmTasks('grunt-postcss');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-watch');
  //grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-cssmin');

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		// Metadata.
		meta: {
		    basePath: './',
				sassPath: './layout/scss',
				cssPath: './layout/css',
		    deployPath: './layout/css'
		},

		// Task configuration.

		cssmin: {
			options: {
				shorthandCompacting: false,
				roundingPrecision: -1
			},
			target: {
				files: [
					{
						src: ['<%= meta.cssPath %>/styles.css'],
						dest: '<%= meta.deployPath %>/styles.min.css'
					}
				]
			}
		},
		/*
		sass: {
	    dist: {
				files : [{
					expand: true,
					cwd: '<%= meta.sassPath %>',
	      	src: ['*.scss'],
	      	dest: '<%= meta.cssPath %>',
					ext: '.css'
				}]
	    },
	  },*/
  	watch: {
	    /*sass: {
	      // We watch and compile sass files as normal but don't live reload here
	      files: ['<%= meta.sassPath %>/*.scss'],
	      tasks: ['sass'],
	    },*/
			cssmin: {
				// We watch and compile sass files as normal but don't live reload here
				files: ['<%= meta.cssPath %>/*.css'],
				tasks: ['cssmin'],
			}/*,
	    livereload: {
	      // Here we watch the files the sass task will compile to
	      // These files are sent to the live reload server after sass compiles to them
	      options: { livereload: true },
	      files: ['<%= meta.deployPath %>/*'],
	    },*/
  },



		/*sass: {
			dist: {
				files: {
					'css/style.css' : 'css/style.scss',
					'css/colors.css' : 'css/colors.scss'
				}
			}
		},*/

		/*postcss: {
		  options: {
			map: true,
			processors: [
			  require('autoprefixer')({browsers: ['last 2 version']}),
			  require('oldie')({  })
			]
		  },
		  dist: {
			src: 'css/*.css'
		  }
		},*/

		/*watch: {
			css: {
				files: '** /*.scss',
				tasks: ['sass']
			}
		}*/



	});


	// Registra i task da svolgere per default, quando lanciamo grunt
	grunt.registerTask('default',['watch']);


	// i prossimi da installare
	// browsersync.io
	// UglifyJS
}
