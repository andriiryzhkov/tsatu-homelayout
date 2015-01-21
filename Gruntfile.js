'use strict';
module.exports = function (grunt) {
    // Load all tasks
    require('load-grunt-tasks')(grunt);
    // Show elapsed time
    require('time-grunt')(grunt);

    var jsFileList = [
        'assets/js/_*.js'
    ];

    grunt.initConfig({
        jshint: {
            options: {
                jshintrc: '.jshintrc'
            },
            all: [
                'Gruntfile.js',
                'assets/js/*.js',
                '!assets/js/scripts.js',
                '!assets/**/*.min.*'
            ]
        },
        less: {
            dev: {
                files: {
                    'assets/css/main.css': [
                        'assets/less/main.less'
                    ]
                },
                options: {
                    compress: false,
                    // LESS source map
                    // To enable, set sourceMap to true and update sourceMapRootpath based on your install
                    sourceMap: true,
                    sourceMapFilename: 'assets/css/main.css.map',
                    sourceMapRootpath: '/wp-content/plugins/tsatu-homelayout/'
                }
            },
            build: {
                files: {
                    'assets/css/main.min.css': [
                        'assets/less/main.less'
                    ]
                },
                options: {
                    compress: true
                }
            }
        },
        concat: {
            options: {
                separator: ';',
            },
            dist: {
                src: [jsFileList],
                dest: 'assets/js/scripts.js',
            },
        },
        copy: {
        },
        uglify: {
            dist: {
                files: {
                    'assets/js/scripts.min.js': [jsFileList]
                }
            }
        },
        autoprefixer: {
            options: {
                browsers: ['last 2 versions', 'ie 8', 'ie 9', 'android 2.3', 'android 4', 'opera 12']
            },
            dev: {
                options: {
                    map: {
                        prev: 'assets/css/'
                    }
                },
                src: 'assets/css/main.css'
            },
            build: {
                src: 'assets/css/main.min.css'
            }
        },
        modernizr: {
            build: {
                devFile: 'assets/vendor/modernizr/modernizr.js',
                outputFile: 'assets/js/vendor/modernizr.min.js',
                files: {
                    'src': [
                        ['assets/js/scripts.min.js'],
                        ['assets/css/main.min.css']
                    ]
                },
                extra: {
                    shiv: false
                },
                uglify: true,
                parseFiles: true
            }
        },
        version: {
            default: {
                options: {
                    format: true,
                    length: 32,
                    manifest: 'assets/manifest.json',
                    querystring: {
                        style: 'tsatu_homelayout_style',
                        script: 'tsatu_homelayout_js'
                    }
                },
                files: {
                    'includes/scripts.php': 'assets/{css,js}/{main,scripts}.min.{css,js}'
                }
            }
        },
        watch: {
            less: {
                files: [
                    'assets/less/*.less',
                    'assets/less/**/*.less'
                ],
                tasks: ['less:dev', 'autoprefixer:dev']
            },
            js: {
                files: [
                    jsFileList,
                    '<%= jshint.all %>'
                ],
                tasks: ['jshint', 'concat']
            },
            livereload: {
                // Browser live reloading
                // https://github.com/gruntjs/grunt-contrib-watch#live-reloading
                options: {
                    livereload: false
                },
                files: [
                    'assets/css/main.css',
                    'assets/js/scripts.js',
                    '*.php'
                ]
            }
        },
        makepot: {
            target: {
                options: {
                    domainPath: '/languages/', // Where to save the POT file.
                    potFilename: 'tsatu-homelayout.pot', // Name of the POT file.
                    type: 'wp-plugin' // Type of project (wp-plugin or wp-theme).
                }
            }
        },
        compress: {
            main: {
                options: {
                    mode: 'zip',
                    archive: './release/tsatu-homelayout-<%= pkg.version %>.zip'
                },
                files: [
                    {src: [
                        '*.php',
                        '*.md',
                        'assets/js/customizer.js',
                        'includes/**',
                        'languages/*'
                    ],
                    dest: 'tsatu-homelayout/'}
                ]
            }
        }

    });

    // Register tasks
    grunt.registerTask('default', [
        'dev'
    ]);
    grunt.registerTask('dev', [
        'jshint',
        'less:dev',
        'autoprefixer:dev',
        'concat'
    ]);
    grunt.registerTask('build', [
        'jshint',
        'less:build',
        'autoprefixer:build',
        //'copy',
        'uglify',
        'modernizr',
        'makepot',
        'version'
    ]);
};
