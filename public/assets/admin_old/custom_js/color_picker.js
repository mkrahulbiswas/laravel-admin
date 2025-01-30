$(document).ready(function () {

    var pathArray = window.location.pathname.split('/');

    if (jQuery.inArray("table", pathArray) >= 1) {
        /*-------- ( Customize Table Start ) --------*/

        if (jQuery.inArray("color", pathArray) >= 1) {

            if (jQuery.inArray("add", pathArray) >= 1) {

                //------ Table Head Add
                Pickr.create({
                        el: '#saveCustomizeTableColorForm .color-picker-1',
                        useAsButton: true,
                        theme: 'classic',

                        components: {

                            preview: true,
                            opacity: true,
                            hue: true,

                            interaction: {
                                hex: true,
                                rgba: true,
                                input: true,
                                clear: true,
                                save: true
                            }
                        }
                    })
                    .on('change', (color, instance) => {
                        var id = $('#saveCustomizeTableColorForm .tableHeadDemo');
                        id.css({
                            background: color.toRGBA()
                        }).find('#backColor').val(color.toRGBA());
                    });

                Pickr.create({
                        el: '#saveCustomizeTableColorForm .color-picker-2',
                        useAsButton: true,
                        theme: 'classic',

                        components: {

                            preview: true,
                            opacity: true,
                            hue: true,

                            interaction: {
                                rgba: true,
                                input: true,
                                clear: true,
                                save: true
                            }
                        }
                    })
                    .on('change', (color, instance) => {
                        var id = $('#saveCustomizeTableColorForm .tableHeadDemo');
                        id.find('p').css({
                            color: color.toRGBA()
                        }).closest('div').find('#textColor').val(color.toRGBA());
                    });

                Pickr.create({
                        el: '#saveCustomizeTableColorForm .color-picker-3',
                        useAsButton: true,
                        theme: 'classic',

                        components: {

                            preview: true,
                            opacity: true,
                            hue: true,

                            interaction: {
                                rgba: true,
                                input: true,
                                clear: true,
                                save: true
                            }
                        }
                    })
                    .on('change', (color, instance) => {
                        var id = $('#saveCustomizeTableColorForm .tableHeadHoverDemo');
                        id.css({
                            background: color.toRGBA()
                        }).find('#backColor').val(color.toRGBA());
                    });

                Pickr.create({
                        el: '#saveCustomizeTableColorForm .color-picker-4',
                        useAsButton: true,
                        theme: 'classic',

                        components: {

                            preview: true,
                            opacity: true,
                            hue: true,

                            interaction: {
                                rgba: true,
                                input: true,
                                clear: true,
                                save: true
                            }
                        }
                    })
                    .on('change', (color, instance) => {
                        var id = $('#saveCustomizeTableColorForm .tableHeadHoverDemo');
                        id.find('p').css({
                            color: color.toRGBA()
                        }).closest('div').find('#textColor').val(color.toRGBA());
                    });


                //------ Table Body Add
                Pickr.create({
                        el: '#saveCustomizeTableColorForm .color-picker-5',
                        useAsButton: true,
                        theme: 'classic',

                        components: {

                            preview: true,
                            opacity: true,
                            hue: true,

                            interaction: {
                                hex: true,
                                rgba: true,
                                input: true,
                                clear: true,
                                save: true
                            }
                        }
                    })
                    .on('change', (color, instance) => {
                        var id = $('#saveCustomizeTableColorForm .tableBodyDemo');
                        id.css({
                            background: color.toRGBA()
                        }).find('#backColor').val(color.toRGBA());
                    });

                Pickr.create({
                        el: '#saveCustomizeTableColorForm .color-picker-6',
                        useAsButton: true,
                        theme: 'classic',

                        components: {

                            preview: true,
                            opacity: true,
                            hue: true,

                            interaction: {
                                rgba: true,
                                input: true,
                                clear: true,
                                save: true
                            }
                        }
                    })
                    .on('change', (color, instance) => {
                        var id = $('#saveCustomizeTableColorForm .tableBodyDemo');
                        id.find('p').css({
                            color: color.toRGBA()
                        }).closest('div').find('#textColor').val(color.toRGBA());
                    });

                Pickr.create({
                        el: '#saveCustomizeTableColorForm .color-picker-7',
                        useAsButton: true,
                        theme: 'classic',

                        components: {

                            preview: true,
                            opacity: true,
                            hue: true,

                            interaction: {
                                rgba: true,
                                input: true,
                                clear: true,
                                save: true
                            }
                        }
                    })
                    .on('change', (color, instance) => {
                        var id = $('#saveCustomizeTableColorForm .tableBodyHoverDemo');
                        id.css({
                            background: color.toRGBA()
                        }).find('#backColor').val(color.toRGBA());
                    });

                Pickr.create({
                        el: '#saveCustomizeTableColorForm .color-picker-8',
                        useAsButton: true,
                        theme: 'classic',

                        components: {

                            preview: true,
                            opacity: true,
                            hue: true,

                            interaction: {
                                rgba: true,
                                input: true,
                                clear: true,
                                save: true
                            }
                        }
                    })
                    .on('change', (color, instance) => {
                        var id = $('#saveCustomizeTableColorForm .tableBodyHoverDemo');
                        id.find('p').css({
                            color: color.toRGBA()
                        }).closest('div').find('#textColor').val(color.toRGBA());
                    });

            } else {

                //------ Table Head Edit
                Pickr.create({
                        el: '#updateCustomizeTableColorForm .color-picker-1',
                        useAsButton: true,
                        theme: 'classic',

                        components: {

                            preview: true,
                            opacity: true,
                            hue: true,

                            interaction: {
                                hex: true,
                                rgba: true,
                                input: true,
                                clear: true,
                                save: true
                            }
                        }
                    })
                    .on('change', (color, instance) => {
                        var id = $('#updateCustomizeTableColorForm .tableHeadDemo');
                        id.css({
                            background: color.toRGBA()
                        }).find('#backColor').val(color.toRGBA());
                    });

                Pickr.create({
                        el: '#updateCustomizeTableColorForm .color-picker-2',
                        useAsButton: true,
                        theme: 'classic',

                        components: {

                            preview: true,
                            opacity: true,
                            hue: true,

                            interaction: {
                                rgba: true,
                                input: true,
                                clear: true,
                                save: true
                            }
                        }
                    })
                    .on('change', (color, instance) => {
                        var id = $('#updateCustomizeTableColorForm .tableHeadDemo');
                        id.find('p').css({
                            color: color.toRGBA()
                        }).closest('div').find('#textColor').val(color.toRGBA());
                    });

                Pickr.create({
                        el: '#updateCustomizeTableColorForm .color-picker-3',
                        useAsButton: true,
                        theme: 'classic',

                        components: {

                            preview: true,
                            opacity: true,
                            hue: true,

                            interaction: {
                                rgba: true,
                                input: true,
                                clear: true,
                                save: true
                            }
                        }
                    })
                    .on('change', (color, instance) => {
                        var id = $('#updateCustomizeTableColorForm .tableHeadHoverDemo');
                        id.css({
                            background: color.toRGBA()
                        }).find('#backColor').val(color.toRGBA());
                    });

                Pickr.create({
                        el: '#updateCustomizeTableColorForm .color-picker-4',
                        useAsButton: true,
                        theme: 'classic',

                        components: {

                            preview: true,
                            opacity: true,
                            hue: true,

                            interaction: {
                                rgba: true,
                                input: true,
                                clear: true,
                                save: true
                            }
                        }
                    })
                    .on('change', (color, instance) => {
                        var id = $('#updateCustomizeTableColorForm .tableHeadHoverDemo');
                        id.find('p').css({
                            color: color.toRGBA()
                        }).closest('div').find('#textColor').val(color.toRGBA());
                    });



                //------ Table Body Edit
                Pickr.create({
                        el: '#updateCustomizeTableColorForm .color-picker-5',
                        useAsButton: true,
                        theme: 'classic',

                        components: {

                            preview: true,
                            opacity: true,
                            hue: true,

                            interaction: {
                                hex: true,
                                rgba: true,
                                input: true,
                                clear: true,
                                save: true
                            }
                        }
                    })
                    .on('change', (color, instance) => {
                        var id = $('#updateCustomizeTableColorForm .tableBodyDemo');
                        id.css({
                            background: color.toRGBA()
                        }).find('#backColor').val(color.toRGBA());
                    });

                Pickr.create({
                        el: '#updateCustomizeTableColorForm .color-picker-6',
                        useAsButton: true,
                        theme: 'classic',

                        components: {

                            preview: true,
                            opacity: true,
                            hue: true,

                            interaction: {
                                rgba: true,
                                input: true,
                                clear: true,
                                save: true
                            }
                        }
                    })
                    .on('change', (color, instance) => {
                        var id = $('#updateCustomizeTableColorForm .tableBodyDemo');
                        id.find('p').css({
                            color: color.toRGBA()
                        }).closest('div').find('#textColor').val(color.toRGBA());
                    });

                Pickr.create({
                        el: '#updateCustomizeTableColorForm .color-picker-7',
                        useAsButton: true,
                        theme: 'classic',

                        components: {

                            preview: true,
                            opacity: true,
                            hue: true,

                            interaction: {
                                rgba: true,
                                input: true,
                                clear: true,
                                save: true
                            }
                        }
                    })
                    .on('change', (color, instance) => {
                        var id = $('#updateCustomizeTableColorForm .tableBodyHoverDemo');
                        id.css({
                            background: color.toRGBA()
                        }).find('#backColor').val(color.toRGBA());
                    });

                Pickr.create({
                        el: '#updateCustomizeTableColorForm .color-picker-8',
                        useAsButton: true,
                        theme: 'classic',

                        components: {

                            preview: true,
                            opacity: true,
                            hue: true,

                            interaction: {
                                rgba: true,
                                input: true,
                                clear: true,
                                save: true
                            }
                        }
                    })
                    .on('change', (color, instance) => {
                        var id = $('#updateCustomizeTableColorForm .tableBodyHoverDemo');
                        id.find('p').css({
                            color: color.toRGBA()
                        }).closest('div').find('#textColor').val(color.toRGBA());
                    });

            }

        } else if (jQuery.inArray("style", pathArray) >= 1) {

            if (jQuery.inArray("add", pathArray) >= 1) {

                //------ Table Head Style Add
                Pickr.create({
                        el: '#saveCustomizeTableStyleForm .color-picker-1',
                        useAsButton: true,
                        theme: 'classic',

                        components: {

                            preview: true,
                            opacity: true,
                            hue: true,

                            interaction: {
                                hex: true,
                                rgba: true,
                                input: true,
                                clear: true
                            }
                        }
                    })
                    .on('change', (color, instance) => {
                        var id = $('#saveCustomizeTableStyleForm .headDecorationColor');
                        id.css({
                            background: color.toRGBA()
                        }).closest('.col-md-2').find('#headDecorationColor').val(color.toRGBA());
                    });


                //------ Table Body Style Add
                Pickr.create({
                        el: '#saveCustomizeTableStyleForm .color-picker-2',
                        useAsButton: true,
                        theme: 'classic',

                        components: {

                            preview: true,
                            opacity: true,
                            hue: true,

                            interaction: {
                                hex: true,
                                rgba: true,
                                input: true,
                                clear: true,
                                save: true
                            }
                        }
                    })
                    .on('change', (color, instance) => {
                        var id = $('#saveCustomizeTableStyleForm .bodyDecorationColor');
                        id.css({
                            background: color.toRGBA()
                        }).closest('.col-md-2').find('#bodyDecorationColor').val(color.toRGBA());
                    });

            } else {

            }

        } else {

        }
        /*-------- ( Customize Table End ) --------*/

    } else {

        /*-------- ( Customize Button Start ) --------*/
        //------ Button Add
        Pickr.create({
                el: '#con-add-modal-button .color-picker-1',
                useAsButton: true,
                theme: 'classic',

                components: {

                    preview: true,
                    opacity: true,
                    hue: true,

                    interaction: {
                        hex: true,
                        rgba: true,
                        input: true,
                        clear: true,
                        save: true
                    }
                }
            })
            .on('change', (color, instance) => {
                var id = $('#con-add-modal-button .btnDemo');
                id.css({
                    background: color.toRGBA()
                }).closest('div').find('#btnBackColor').val(color.toRGBA());
            });

        Pickr.create({
                el: '#con-add-modal-button .color-picker-2',
                useAsButton: true,
                theme: 'classic',

                components: {

                    preview: true,
                    opacity: true,
                    hue: true,

                    interaction: {
                        rgba: true,
                        input: true,
                        clear: true,
                        save: true
                    }
                }
            })
            .on('change', (color, instance) => {
                var id = $('#con-add-modal-button .btnDemo');
                id.find('p').css({
                    color: color.toRGBA()
                });
                id.find('#btnTextColor').val(color.toRGBA());
            });

        Pickr.create({
                el: '#con-add-modal-button .color-picker-3',
                useAsButton: true,
                theme: 'classic',

                components: {

                    preview: true,
                    opacity: true,
                    hue: true,

                    interaction: {
                        rgba: true,
                        input: true,
                        clear: true,
                        save: true
                    }
                }
            })
            .on('change', (color, instance) => {
                var id = $('#con-add-modal-button .btnHoverDemo');
                id.css({
                    background: color.toRGBA()
                }).closest('div').find('#btnHoverBackColor').val(color.toRGBA());
            });

        Pickr.create({
                el: '#con-add-modal-button .color-picker-4',
                useAsButton: true,
                theme: 'classic',

                components: {

                    preview: true,
                    opacity: true,
                    hue: true,

                    interaction: {
                        rgba: true,
                        input: true,
                        clear: true,
                        save: true
                    }
                }
            })
            .on('change', (color, instance) => {
                var id = $('#con-add-modal-button .btnHoverDemo');
                id.find('p').css({
                    color: color.toRGBA()
                });
                id.find('#btnHoverTextColor').val(color.toRGBA());
            });



        //------ Button Edit
        Pickr.create({
                el: '#con-edit-modal-button .color-picker-1',
                useAsButton: true,
                theme: 'classic',

                components: {

                    preview: true,
                    opacity: true,
                    hue: true,

                    interaction: {
                        rgba: true,
                        input: true,
                        clear: true,
                        save: true
                    }
                }
            })
            .on('change', (color, instance) => {
                var id = $('#con-edit-modal-button .btnDemo');
                id.css({
                    background: color.toRGBA()
                });
                id.find('#btnBackColor').val(color.toRGBA());
            });

        Pickr.create({
                el: '#con-edit-modal-button .color-picker-2',
                useAsButton: true,
                theme: 'classic',

                components: {

                    preview: true,
                    opacity: true,
                    hue: true,

                    interaction: {
                        rgba: true,
                        input: true,
                        clear: true,
                        save: true
                    }
                }
            })
            .on('change', (color, instance) => {
                var id = $('#con-edit-modal-button .btnDemo');
                id.find('p').css({
                    color: color.toRGBA()
                }).closest('div').find('#btnTextColor').val(color.toRGBA());
            });

        Pickr.create({
                el: '#con-edit-modal-button .color-picker-3',
                useAsButton: true,
                theme: 'classic',

                components: {

                    preview: true,
                    opacity: true,
                    hue: true,

                    interaction: {
                        rgba: true,
                        input: true,
                        clear: true,
                        save: true
                    }
                }
            })
            .on('change', (color, instance) => {
                var id = $('#con-edit-modal-button .btnHoverDemo');
                id.css({
                    background: color.toRGBA()
                });
                id.find('#btnHoverBackColor').val(color.toRGBA());
            });

        Pickr.create({
                el: '#con-edit-modal-button .color-picker-4',
                useAsButton: true,
                theme: 'classic',

                components: {

                    preview: true,
                    opacity: true,
                    hue: true,

                    interaction: {
                        rgba: true,
                        input: true,
                        clear: true,
                        save: true
                    }
                }
            })
            .on('change', (color, instance) => {
                var id = $('#con-edit-modal-button .btnHoverDemo');
                id.find('p').css({
                    color: color.toRGBA()
                }).closest('div').find('#btnHoverTextColor').val(color.toRGBA());
            });
        /*-------- ( Customize Button End ) --------*/

    }


});
