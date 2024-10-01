<?php
if (!defined("ABSPATH")) {
    exit(); // Exit if accessed directly.
}

/**
 * Elementor slider-grid-cards Widget.
 *
 * Elementor widget that inserts embeddable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Elementor_Slider_Grid_Cards_Widget extends \Elementor\Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve slider-grid-cards widget name.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget name.
     */
    public function get_name()
    {
        return "slider-grid-cards";
    }

    /**
     * Get widget title.
     *
     * Retrieve slider-grid-cards widget title.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget title.
     */
    public function get_title()
    {
        return esc_html__(
            "Slider/Grid Cards",
            "elementor-slider-grid-cards-widget"
        );
    }

    /**
     * Get widget icon.
     *
     * Retrieve slider-grid-cards widget icon.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return "eicon-slides";
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the slider-grid-cards widget belongs to.
     *
     * @since 1.0.0
     * @access public
     * @return array Widget categories.
     */
    public function get_categories()
    {
        return ["general"];
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the slider-grid-cards widget belongs to.
     *
     * @since 1.0.0
     * @access public
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
        return ["slider-grid-cards", "url", "link"];
    }
    public function get_script_depends() {
        // Ensure Elementor's Swiper script is enqueued
        return [ 'slider-grid-cards-init', 'swiper' ];
    }
    /**
     * Register slider-grid-cards widget controls.
     *
     * Add input fields to allow the user to customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls(){
        /*Adding Cards Content Tab*/
        $this->start_controls_section("content_section", [
            "label" => esc_html__(
                "Cards Content",
                "elementor-slider-grid-cards-widget"
            ),
            "tab" => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control("heading", [
            "label" => esc_html__(
                "Heading",
                "elementor-slider-grid-cards-widget"
            ),
            "type" => \Elementor\Controls_Manager::TEXT,
            "default" => esc_html__(
                "Heading",
                "elementor-slider-grid-cards-widget"
            ),
            "placeholder" => esc_html__(
                "Enter your heading",
                "elementor-slider-grid-cards-widget"
            ),
        ]);
        $this->add_control(
            "view_type",
            [
                "label" => esc_html__( "View Type", "elementor-slider-grid-cards-widget" ),
                "type" => \Elementor\Controls_Manager::SELECT,
                "options" => [
                    "slider" => esc_html__( "Slider", "elementor-slider-grid-cards-widget" ),
                    "grid" => esc_html__( "Grid", "elementor-slider-grid-cards-widget" ),
                ],
                "default" => "slider",
                "render_type" => 'template', // This ensures the widget is re-rendered when changed
            ]
        );
        
        // Repeater for Cards
        $repeater = new \Elementor\Repeater();
        $repeater->add_control("card_image", [
            "label" => esc_html__(
                "Choose Image",
                "elementor-slider-grid-cards-widget"
            ),
            "type" => \Elementor\Controls_Manager::MEDIA,
            "default" => [
                "url" => \Elementor\Utils::get_placeholder_image_src(),
            ],
        ]);
        $repeater->add_control("card_title", [
            "label" => esc_html__(
                "Title",
                "elementor-slider-grid-cards-widget"
            ),
            "type" => \Elementor\Controls_Manager::TEXT,
            "default" => esc_html__(
                "Card Title",
                "elementor-slider-grid-cards-widget"
            ),
            "label_block" => true,
            "render_type" => 'template', // This ensures the widget is re-rendered when changed

        ]);
        // Adding Subtitle Field
        $repeater->add_control("card_subtitle", [
            "label" => esc_html__(
                "Subtitle",
                "elementor-slider-grid-cards-widget"
            ),
            "type" => \Elementor\Controls_Manager::TEXT,
            "default" => esc_html__(
                "Card Subtitle",
                "elementor-slider-grid-cards-widget"
            ),
            "label_block" => true,
        ]);
        // Adding description Field
        $repeater->add_control("card_description", [
            "label" => esc_html__(
                "Description",
                "elementor-slider-grid-cards-widget"
            ),
            "type" => \Elementor\Controls_Manager::TEXTAREA,
            "default" => esc_html__(
                "Card Description",
                "elementor-slider-grid-cards-widget"
            ),
            "show_label" => false,
        ]);
        // Adding Bottom Content Field
        $repeater->add_control("card_bottom_content", [
            "label" => esc_html__(
                "Bottom Content",
                "elementor-slider-grid-cards-widget"
            ),
            "type" => \Elementor\Controls_Manager::TEXTAREA,
            "default" => esc_html__(
                "Additional Bottom Content",
                "elementor-slider-grid-cards-widget"
            ),
            "label_block" => true,
        ]);

        // Adding Button Text Field
        $repeater->add_control("card_button_text", [
            "label" => esc_html__(
                "Button Text",
                "elementor-slider-grid-cards-widget"
            ),
            "type" => \Elementor\Controls_Manager::TEXT,
            "default" => esc_html__(
                "Read More",
                "elementor-slider-grid-cards-widget"
            ),
            "label_block" => true,
        ]);

        // Adding Button URL Field
        $repeater->add_control("card_button_url", [
            "label" => esc_html__(
                "Button URL",
                "elementor-slider-grid-cards-widget"
            ),
            "type" => \Elementor\Controls_Manager::URL,
            "placeholder" => esc_html__(
                "https://your-link.com",
                "elementor-slider-grid-cards-widget"
            ),
            "default" => [
                "url" => "",
                "is_external" => false,
                "nofollow" => false,
            ],
            "label_block" => true,
        ]);
        // Initiate 3 Cards
        $this->add_control("cards", [
            "label" => esc_html__(
                "Cards",
                "elementor-slider-grid-cards-widget"
            ),
            "type" => \Elementor\Controls_Manager::REPEATER,
            "fields" => $repeater->get_controls(),
            "default" => [
                [
                    "card_title" => esc_html__(
                        "Card 1",
                        "elementor-slider-grid-cards-widget"
                    ),
                ],
                [
                    "card_title" => esc_html__(
                        "Card 2",
                        "elementor-slider-grid-cards-widget"
                    ),
                ],
                [
                    "card_title" => esc_html__(
                        "Card 3",
                        "elementor-slider-grid-cards-widget"
                    ),
                ],
            ],
        ]);
        $this->end_controls_section();

        /*Adding Slider Options*/
        $this->start_controls_section("slider_options", [
            "label" => esc_html__(
                "Slider Options",
                "elementor-slider-grid-cards-widget"
            ),
            "tab" => \Elementor\Controls_Manager::TAB_CONTENT,
            "condition" => [
                "view_type" => "slider",
            ],
        ]);
        $this->add_control("autoplay", [
            "label" => esc_html__("Autoplay", "slider-grid-cards"),
            "type" => \Elementor\Controls_Manager::SWITCHER,
            "label_on" => esc_html__("Yes", "slider-grid-cards"),
            "label_off" => esc_html__("No", "slider-grid-cards"),
            "return_value" => "yes",
            "default" => "yes",
            "condition" => [
                "view_type" => "slider",
            ],
        ]);
        $this->add_control("show_arrows", [
            "label" => esc_html__("Show Arrows", "slider-grid-cards"),
            "type" => \Elementor\Controls_Manager::SWITCHER,
            "label_on" => esc_html__("Yes", "slider-grid-cards"),
            "label_off" => esc_html__("No", "slider-grid-cards"),
            "return_value" => "yes",
            "default" => "yes",
            "condition" => [
                "view_type" => "slider",
            ],
        ]);
        $this->add_control("loop", [
            "label" => __("Loop", "slider-grid-cards"),
            "type" => \Elementor\Controls_Manager::SWITCHER,
            "label_on" => __("Yes", "slider-grid-cards"),
            "label_off" => __("No", "slider-grid-cards"),
            "return_value" => "yes",
            "default" => "no",
            "condition" => [
                "view_type" => "slider",
            ],
        ]);
        $this->add_control("slides_to_show", [
            "label" => esc_html__("Slides to Show", "slider-grid-cards"),
            "type" => \Elementor\Controls_Manager::NUMBER,
            "default" => 2,
            "min" => 1,
            "max" => 10,
            "step" => 1,
            "condition" => [
                "view_type" => "slider",
            ],
        ]);
        $this->end_controls_section();

        /*Adding toggle Options*/
        $this->start_controls_section("toggle_options", [
            "label" => esc_html__(
                "Toggle Options",
                "elementor-slider-grid-cards-widget"
            ),
            "tab" => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control("show_image_logo", [
            "label" => esc_html__(
                "Show Image/Logo",
                "elementor-slider-grid-cards-widget"
            ),
            "type" => \Elementor\Controls_Manager::SWITCHER,
            "label_on" => esc_html__(
                "Show",
                "elementor-slider-grid-cards-widget"
            ),
            "label_off" => esc_html__(
                "Hide",
                "elementor-slider-grid-cards-widget"
            ),
            "return_value" => "show",
            "default" => "show",
        ]);
        $this->add_control("show_title", [
            "label" => esc_html__(
                "Show Title",
                "elementor-slider-grid-cards-widget"
            ),
            "type" => \Elementor\Controls_Manager::SWITCHER,
            "label_on" => esc_html__(
                "Show",
                "elementor-slider-grid-cards-widget"
            ),
            "label_off" => esc_html__(
                "Hide",
                "elementor-slider-grid-cards-widget"
            ),
            "return_value" => "show",
            "default" => "show",
        ]);
        $this->add_control("show_sub_title", [
            "label" => esc_html__(
                "Show Sub-Title",
                "elementor-slider-grid-cards-widget"
            ),
            "type" => \Elementor\Controls_Manager::SWITCHER,
            "label_on" => esc_html__(
                "Show",
                "elementor-slider-grid-cards-widget"
            ),
            "label_off" => esc_html__(
                "Hide",
                "elementor-slider-grid-cards-widget"
            ),
            "return_value" => "show",
            "default" => "show",
        ]);
        $this->add_control("show_description", [
            "label" => esc_html__(
                "Show Description",
                "elementor-slider-grid-cards-widget"
            ),
            "type" => \Elementor\Controls_Manager::SWITCHER,
            "label_on" => esc_html__(
                "Show",
                "elementor-slider-grid-cards-widget"
            ),
            "label_off" => esc_html__(
                "Hide",
                "elementor-slider-grid-cards-widget"
            ),
            "return_value" => "show",
            "default" => "show",
        ]);
        $this->add_control("show_bottom_content", [
            "label" => esc_html__(
                "Show Bottom Content",
                "elementor-slider-grid-cards-widget"
            ),
            "type" => \Elementor\Controls_Manager::SWITCHER,
            "label_on" => esc_html__(
                "Show",
                "elementor-slider-grid-cards-widget"
            ),
            "label_off" => esc_html__(
                "Hide",
                "elementor-slider-grid-cards-widget"
            ),
            "return_value" => "show",
            "default" => "show",
        ]);
        $this->add_control("show_btn", [
            "label" => esc_html__(
                "Show Button",
                "elementor-slider-grid-cards-widget"
            ),
            "type" => \Elementor\Controls_Manager::SWITCHER,
            "label_on" => esc_html__(
                "Show",
                "elementor-slider-grid-cards-widget"
            ),
            "label_off" => esc_html__(
                "Hide",
                "elementor-slider-grid-cards-widget"
            ),
            "return_value" => "show",
            "default" => "show",
        ]);
        $this->end_controls_section();

        // Styles Tab Section for Main Container
        $this->start_controls_section("main_container_styles", [
            "label" => esc_html__("Main Container", "elementor-slider-grid-cards-widget"),
            "tab" => \Elementor\Controls_Manager::TAB_STYLE,
        ]);


        // Main Background Color Control
        $this->add_control("main_background_color", [
            "label" => esc_html__("Background Color", "elementor-slider-grid-cards-widget"),
            "type" => \Elementor\Controls_Manager::COLOR,
            "selectors" => [
                "{{WRAPPER}} .main-slider-grid-container" => "background-color: {{VALUE}};",
            ],
            "default" => "#d9f1ee",
        ]);

        // Padding Control
        $this->add_control('main_container_padding', [
            'label' => esc_html__('Padding', 'elementor-slider-grid-cards-widget'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'], // Define the units you want to allow
            'selectors' => [
                '{{WRAPPER}} .main-slider-grid-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],            
        ]);

        $this->end_controls_section();

        // Styles Tab Section for Cards
        $this->start_controls_section("cards_styles", [
            "label" => esc_html__("Cards", "elementor-slider-grid-cards-widget"),
            "tab" => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        // Card Background Color Control
        $this->add_control("card_background_color", [
            "label" => esc_html__("Background Color", "elementor-slider-grid-cards-widget"),
            "type" => \Elementor\Controls_Manager::COLOR,
            "selectors" => [
                "{{WRAPPER}} .card-box-container" => "background-color: {{VALUE}};",
            ],
            "default" => "#FFF",
        ]);


        // Padding Control
        $this->add_control('card_padding', [
            'label' => esc_html__('Padding', 'elementor-slider-grid-cards-widget'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'], // Define the units you want to allow
            'selectors' => [
                '{{WRAPPER}} .card-box-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],            
        ]);

        // Margin Control
        $this->add_control('card_margin', [
            'label' => esc_html__('Margin', 'elementor-slider-grid-cards-widget'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'], // Define the units you want to allow
            'selectors' => [
                '{{WRAPPER}} .card-box-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();


        // Styles Tab Section for Heading
        $this->start_controls_section("heading_styles", [
            "label" => esc_html__(
                "Heading",
                "elementor-slider-grid-cards-widget"
            ),
            "tab" => \Elementor\Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control("heading_color", [
            "label" => esc_html__(
                "Color",
                "elementor-slider-grid-cards-widget"
            ),
            "type" => \Elementor\Controls_Manager::COLOR,
            "selectors" => [
                "{{WRAPPER}} .widget-heading h2" => "color: {{VALUE}};",
            ],
        ]);
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                "name" => "heading_typography",
                "label" => esc_html__(
                    "Typography",
                    "elementor-slider-grid-cards-widget"
                ),
                "selector" => "{{WRAPPER}} .widget-heading h2",
                ]
        );

        // Alignment Control for Heading
        $this->add_control("heading_alignment", [
            "label" => esc_html__(
                "Alignment",
                "elementor-slider-grid-cards-widget"
            ),
            "type" => \Elementor\Controls_Manager::CHOOSE,
            "options" => [
                "left" => [
                    "title" => esc_html__(
                        "Left",
                        "elementor-slider-grid-cards-widget"
                    ),
                    "icon" => "eicon-text-align-left",
                ],
                "center" => [
                    "title" => esc_html__(
                        "Center",
                        "elementor-slider-grid-cards-widget"
                    ),
                    "icon" => "eicon-text-align-center",
                ],
                "right" => [
                    "title" => esc_html__(
                        "Right",
                        "elementor-slider-grid-cards-widget"
                    ),
                    "icon" => "eicon-text-align-right",
                ],
            ],
            "default" => "left",
            "selectors" => [
                "{{WRAPPER}} .widget-heading" => "text-align: {{VALUE}};",
            ],
        ]);

        // Padding Control
        $this->add_control('heading_padding', [
            'label' => esc_html__('Padding', 'elementor-slider-grid-cards-widget'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'], // Define the units you want to allow
            'selectors' => [
                '{{WRAPPER}} .widget-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],            
        ]);

        // Margin Control
        $this->add_control('heading_margin', [
            'label' => esc_html__('Margin', 'elementor-slider-grid-cards-widget'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'], // Define the units you want to allow
            'selectors' => [
                '{{WRAPPER}} .widget-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        
        $this->end_controls_section();

        // Styles Tab Section for Image
        $this->start_controls_section("image_styles", [
            "label" => esc_html__("Image", "elementor-slider-grid-cards-widget"),
            "tab" => \Elementor\Controls_Manager::TAB_STYLE,
        ]);
        
        // Image View Control
  
        $this->add_control(
            'image_size',
            [
                'label' => __( 'Image View', 'elementor-slider-grid-cards-widget' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'default' => 'normal_image_css',
                'options' => [
                    'normal_image_css' => [
                        'title' => esc_html__('Normal', 'elementor-slider-grid-cards-widget'),
                        'icon' => 'eicon-image',
                    ],
                    'logo_image_css' => [
                        'title' => esc_html__('Logo', 'elementor-slider-grid-cards-widget'),
                        'icon' => 'eicon-logo',
                    ],
                ],
            ]
            
        );
        
        // Alignment Control for Image
        $this->add_control("image_alignment", [
            "label" => esc_html__(
                "Alignment",
                "elementor-slider-grid-cards-widget"
            ),
            "type" => \Elementor\Controls_Manager::CHOOSE,
            "options" => [
                "left" => [
                    "title" => esc_html__(
                        "Left",
                        "elementor-slider-grid-cards-widget"
                    ),
                    "icon" => "eicon-text-align-left",
                ],
                "center" => [
                    "title" => esc_html__(
                        "Center",
                        "elementor-slider-grid-cards-widget"
                    ),
                    "icon" => "eicon-text-align-center",
                ],
                "right" => [
                    "title" => esc_html__(
                        "Right",
                        "elementor-slider-grid-cards-widget"
                    ),
                    "icon" => "eicon-text-align-right",
                ],
            ],
            "default" => "left",
            "selectors" => [
                "{{WRAPPER}} .cards-image-wrapper" => "text-align: {{VALUE}};",
            ],
        ]);

        // Padding Control
        $this->add_control('image_padding', [
            'label' => esc_html__('Padding', 'elementor-slider-grid-cards-widget'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'], // Define the units you want to allow
            'selectors' => [
                '{{WRAPPER}} .cards-image-wrapper img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],            
        ]);

        // Margin Control
        $this->add_control('image_margin', [
            'label' => esc_html__('Margin', 'elementor-slider-grid-cards-widget'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'], // Define the units you want to allow
            'selectors' => [
                '{{WRAPPER}} .cards-image-wrapper img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        // Styles Tab Section for Title
        $this->start_controls_section("title_styles", [
            "label" => esc_html__(
                "Title",
                "elementor-slider-grid-cards-widget"
            ),
            "tab" => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control("title_color", [
            "label" => esc_html__(
                "Color",
                "elementor-slider-grid-cards-widget"
            ),
            "type" => \Elementor\Controls_Manager::COLOR,
            "selectors" => [
                "{{WRAPPER}} .cards-title-wrapper h3" => "color: {{VALUE}};",
            ],
        ]);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                "name" => "title_typography",
                "label" => esc_html__(
                    "Typography",
                    "elementor-slider-grid-cards-widget"
                ),
                "selector" => "{{WRAPPER}} .cards-title-wrapper h3",
            ]
        );

        // Alignment Control for Title
        $this->add_control("title_alignment", [
            "label" => esc_html__(
                "Alignment",
                "elementor-slider-grid-cards-widget"
            ),
            "type" => \Elementor\Controls_Manager::CHOOSE,
            "options" => [
                "left" => [
                    "title" => esc_html__(
                        "Left",
                        "elementor-slider-grid-cards-widget"
                    ),
                    "icon" => "eicon-text-align-left",
                ],
                "center" => [
                    "title" => esc_html__(
                        "Center",
                        "elementor-slider-grid-cards-widget"
                    ),
                    "icon" => "eicon-text-align-center",
                ],
                "right" => [
                    "title" => esc_html__(
                        "Right",
                        "elementor-slider-grid-cards-widget"
                    ),
                    "icon" => "eicon-text-align-right",
                ],
            ],
            "default" => "left",
            "selectors" => [
                "{{WRAPPER}} .cards-title-wrapper h3" => "text-align: {{VALUE}};",
            ],
        ]);


        // Padding Control
        $this->add_control('title_padding', [
            'label' => esc_html__('Padding', 'elementor-slider-grid-cards-widget'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'], // Define the units you want to allow
            'selectors' => [
                '{{WRAPPER}} .cards-title-wrapper h3' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],            
        ]);

        // Margin Control
        $this->add_control('title_margin', [
            'label' => esc_html__('Margin', 'elementor-slider-grid-cards-widget'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'], // Define the units you want to allow
            'selectors' => [
                '{{WRAPPER}} .cards-title-wrapper h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        // Styles Tab Section for Sub-Title
        $this->start_controls_section("sub_title_styles", [
            "label" => esc_html__(
                "Sub-Title",
                "elementor-slider-grid-cards-widget"
            ),
            "tab" => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control("sub_title_color", [
            "label" => esc_html__(
                "Color",
                "elementor-slider-grid-cards-widget"
            ),
            "type" => \Elementor\Controls_Manager::COLOR,
            "selectors" => [
                "{{WRAPPER}} .cards-subtitle-wrapper h4" => "color: {{VALUE}};",
            ],
        ]);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                "name" => "sub_title_typography",
                "label" => esc_html__(
                    "Typography",
                    "elementor-slider-grid-cards-widget"
                ),
                "selector" => "{{WRAPPER}} .cards-subtitle-wrapper h4",
            ]
        );

        // Alignment Control for Sub-Title
        $this->add_control("sub_title_alignment", [
            "label" => esc_html__(
                "Alignment",
                "elementor-slider-grid-cards-widget"
            ),
            "type" => \Elementor\Controls_Manager::CHOOSE,
            "options" => [
                "left" => [
                    "title" => esc_html__(
                        "Left",
                        "elementor-slider-grid-cards-widget"
                    ),
                    "icon" => "eicon-text-align-left",
                ],
                "center" => [
                    "title" => esc_html__(
                        "Center",
                        "elementor-slider-grid-cards-widget"
                    ),
                    "icon" => "eicon-text-align-center",
                ],
                "right" => [
                    "title" => esc_html__(
                        "Right",
                        "elementor-slider-grid-cards-widget"
                    ),
                    "icon" => "eicon-text-align-right",
                ],
            ],
            "default" => "left",
            "selectors" => [
                "{{WRAPPER}} .cards-subtitle-wrapper h4" => "text-align: {{VALUE}};",
            ],
        ]);

        // Padding Control
        $this->add_control('subtitle_padding', [
            'label' => esc_html__('Padding', 'elementor-slider-grid-cards-widget'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'], // Define the units you want to allow
            'selectors' => [
                '{{WRAPPER}} .cards-subtitle-wrapper h4' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],            
        ]);

        // Margin Control
        $this->add_control('subtitle_margin', [
            'label' => esc_html__('Margin', 'elementor-slider-grid-cards-widget'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'], // Define the units you want to allow
            'selectors' => [
                '{{WRAPPER}} .cards-subtitle-wrapper h4' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        // Styles Tab Section for Description
        $this->start_controls_section("description_styles", [
            "label" => esc_html__(
                "Description",
                "elementor-slider-grid-cards-widget"
            ),
            "tab" => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control("description_color", [
            "label" => esc_html__(
                "Color",
                "elementor-slider-grid-cards-widget"
            ),
            "type" => \Elementor\Controls_Manager::COLOR,
            "selectors" => [
                "{{WRAPPER}} .cards-description-wrapper p" => "color: {{VALUE}};",
            ],
        ]);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                "name" => "description_typography",
                "label" => esc_html__(
                    "Typography",
                    "elementor-slider-grid-cards-widget"
                ),
                "selector" => "{{WRAPPER}} .cards-description-wrapper p",
            ]
        );

        // Alignment Control for Description
        $this->add_control("description_alignment", [
            "label" => esc_html__(
                "Alignment",
                "elementor-slider-grid-cards-widget"
            ),
            "type" => \Elementor\Controls_Manager::CHOOSE,
            "options" => [
                "left" => [
                    "title" => esc_html__(
                        "Left",
                        "elementor-slider-grid-cards-widget"
                    ),
                    "icon" => "eicon-text-align-left",
                ],
                "center" => [
                    "title" => esc_html__(
                        "Center",
                        "elementor-slider-grid-cards-widget"
                    ),
                    "icon" => "eicon-text-align-center",
                ],
                "right" => [
                    "title" => esc_html__(
                        "Right",
                        "elementor-slider-grid-cards-widget"
                    ),
                    "icon" => "eicon-text-align-right",
                ],
            ],
            "default" => "left",
            "selectors" => [
                "{{WRAPPER}} .cards-description-wrapper p" =>
                    "text-align: {{VALUE}};",
            ],
        ]);

        // Padding Control
        $this->add_control('description_padding', [
            'label' => esc_html__('Padding', 'elementor-slider-grid-cards-widget'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'], // Define the units you want to allow
            'selectors' => [
                '{{WRAPPER}} .cards-description-wrapper p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],            
        ]);

        // Margin Control
        $this->add_control('description_margin', [
            'label' => esc_html__('Margin', 'elementor-slider-grid-cards-widget'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'], // Define the units you want to allow
            'selectors' => [
                '{{WRAPPER}} .cards-description-wrapper p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        // Styles Tab Section for Bottom Content
        $this->start_controls_section("bottom_content_styles", [
            "label" => esc_html__(
                "Bottom Content",
                "elementor-slider-grid-cards-widget"
            ),
            "tab" => \Elementor\Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control("bottom_content_color", [
            "label" => esc_html__(
                "Color",
                "elementor-slider-grid-cards-widget"
            ),
            "type" => \Elementor\Controls_Manager::COLOR,
            "selectors" => [
                "{{WRAPPER}} .cards-bottom-content-wrapper p" => "color: {{VALUE}};",
            ],
        ]);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                "name" => "bottom_content_typography",
                "label" => esc_html__(
                    "Typography",
                    "elementor-slider-grid-cards-widget"
                ),
                "selector" => "{{WRAPPER}} .cards-bottom-content-wrapper p",
            ]
        );

        // Alignment Control for Bottom Content
        $this->add_control("bottom_content_alignment", [
            "label" => esc_html__(
                "Alignment",
                "elementor-slider-grid-cards-widget"
            ),
            "type" => \Elementor\Controls_Manager::CHOOSE,
            "options" => [
                "left" => [
                    "title" => esc_html__(
                        "Left",
                        "elementor-slider-grid-cards-widget"
                    ),
                    "icon" => "eicon-text-align-left",
                ],
                "center" => [
                    "title" => esc_html__(
                        "Center",
                        "elementor-slider-grid-cards-widget"
                    ),
                    "icon" => "eicon-text-align-center",
                ],
                "right" => [
                    "title" => esc_html__(
                        "Right",
                        "elementor-slider-grid-cards-widget"
                    ),
                    "icon" => "eicon-text-align-right",
                ],
            ],
            "default" => "left",
            "selectors" => [
                "{{WRAPPER}} .cards-bottom-content-wrapper p" =>
                    "text-align: {{VALUE}};",
            ],
        ]);


        // Padding Control
        $this->add_control('bottom_content_padding', [
            'label' => esc_html__('Padding', 'elementor-slider-grid-cards-widget'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'], // Define the units you want to allow
            'selectors' => [
                '{{WRAPPER}} .cards-bottom-content-wrapper p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],            
        ]);

        // Margin Control
        $this->add_control('bottom_content_margin', [
            'label' => esc_html__('Margin', 'elementor-slider-grid-cards-widget'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'], // Define the units you want to allow
            'selectors' => [
                '{{WRAPPER}} .cards-bottom-content-wrapper p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        // Styles Tab Section for Button
        $this->start_controls_section("button_styles", [
            "label" => esc_html__(
                "Button",
                "elementor-slider-grid-cards-widget"
            ),
            "tab" => \Elementor\Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control("button_text_color", [
            "label" => esc_html__(
                "Text Color",
                "elementor-slider-grid-cards-widget"
            ),
            "type" => \Elementor\Controls_Manager::COLOR,
            "selectors" => [
                "{{WRAPPER}} .cards-button-wrapper .card-button" => "color: {{VALUE}};",
            ],
        ]);
        $this->add_control("button_background_color", [
            "label" => esc_html__(
                "Background Color",
                "elementor-slider-grid-cards-widget"
            ),
            "type" => \Elementor\Controls_Manager::COLOR,
            "selectors" => [
                "{{WRAPPER}} .cards-button-wrapper .card-button" =>
                    "background-color: {{VALUE}};",
            ],
        ]);
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                "name" => "button_typography",
                "label" => esc_html__(
                    "Typography",
                    "elementor-slider-grid-cards-widget"
                ),
                "selector" => "{{WRAPPER}} .cards-button-wrapper .card-button",
            ]
        );
        $this->add_group_control(\Elementor\Group_Control_Border::get_type(), [
            "name" => "button_border",
            "label" => esc_html__(
                "Border",
                "elementor-slider-grid-cards-widget"
            ),
            "selector" => "{{WRAPPER}} .cards-button-wrapper .card-button",
        ]);
        // Alignment Control for Button
        $this->add_control("button_alignment", [
            "label" => esc_html__(
                "Alignment",
                "elementor-slider-grid-cards-widget"
            ),
            "type" => \Elementor\Controls_Manager::CHOOSE,
            "options" => [
                "left" => [
                    "title" => esc_html__(
                        "Left",
                        "elementor-slider-grid-cards-widget"
                    ),
                    "icon" => "eicon-text-align-left",
                ],
                "center" => [
                    "title" => esc_html__(
                        "Center",
                        "elementor-slider-grid-cards-widget"
                    ),
                    "icon" => "eicon-text-align-center",
                ],
                "right" => [
                    "title" => esc_html__(
                        "Right",
                        "elementor-slider-grid-cards-widget"
                    ),
                    "icon" => "eicon-text-align-right",
                ],
            ],
            "default" => "left",
            "selectors" => [
                "{{WRAPPER}} .cards-button-wrapper" => "text-align: {{VALUE}};",
            ],
        ]);


        // Padding Control
        $this->add_control('button_padding', [
            'label' => esc_html__('Padding', 'elementor-slider-grid-cards-widget'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'], // Define the units you want to allow
            'selectors' => [
                '{{WRAPPER}} .cards-button-wrapper a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],            
        ]);

        // Margin Control
        $this->add_control('button_margin', [
            'label' => esc_html__('Margin', 'elementor-slider-grid-cards-widget'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'], // Define the units you want to allow
            'selectors' => [
                '{{WRAPPER}} .cards-button-wrapper a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        
        $this->end_controls_section();
    }

    /**
     * Render slider-grid-cards widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
        $settings            = $this->get_settings_for_display();
        $view_type           = $settings["view_type"];
        $cards               = $settings["cards"];
        $heading             = !empty($settings["heading"]) ? esc_html($settings["heading"]) : "";
        $show_image_logo     = !empty($settings["show_image_logo"]) && $settings["show_image_logo"] === 'show';
        $show_title          = !empty($settings["show_title"]) && $settings["show_title"] === 'show';
        $show_sub_title      = !empty($settings["show_sub_title"]) && $settings["show_sub_title"] === 'show';
        $show_description    = !empty($settings["show_description"]) && $settings["show_description"] === 'show';
        $show_bottom_content = !empty($settings["show_bottom_content"]) && $settings["show_bottom_content"] === 'show';
        $show_btn            = !empty($settings["show_btn"]) && $settings["show_btn"] === 'show';        
        $img_size_custom_css = ($settings['image_size'] === 'logo_image_css') ? 'max-width: 100%;height: auto;' : 'height: 500px;width: 100%;object-fit: cover;';
        $autoplay            = $settings["autoplay"] === "yes" ? "true" : "false";
        $loop                = $settings["loop"] === "yes" ? "true" : "false";
        $slides_to_show      = !empty($settings["slides_to_show"]) ? intval($settings["slides_to_show"])  : 1;
        ?>
        <div class="main-slider-grid-container">
            <?php if ($heading): ?>
            <div class="widget-heading">
                <h2><?php echo esc_html($heading); ?></h2>
            </div>
            <?php endif; ?>
            <?php if ("slider" === $view_type): ?>
            <!-- Slider view -->
            <div class="swiper-container" data-autoplay="<?php echo esc_attr($autoplay); ?>" data-loop="<?php echo esc_attr($loop); ?>" data-slides-to-show="<?php echo esc_attr($slides_to_show); ?>">
                <div class="swiper-wrapper">
                    <?php foreach ($cards as $slide): ?>
                    <div class="swiper-slide card-box-container">
                        <?php if (!empty($slide["card_image"]["url"]) && !empty($show_image_logo)): ?>
                            <div class="cards-image-wrapper">
                                <img src="<?php echo esc_url($slide["card_image"]["url"]); ?>"
                                    alt="<?php echo esc_attr($slide["card_title"]); ?>"
                                    style="<?php echo esc_attr($img_size_custom_css); ?>"
                                >
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($slide["card_title"]) && !empty($show_title)): ?>
                            <div class="cards-title-wrapper">
                                <h3><?php echo esc_html($slide["card_title"]); ?></h3>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($slide["card_subtitle"]) && !empty( $show_sub_title )): ?>
                            <div class="cards-subtitle-wrapper">
                                <h4><?php echo esc_html($slide["card_subtitle"]); ?></h4>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($slide["card_description"]) && !empty( $show_description )): ?>
                            <div class="cards-description-wrapper">
                                <p><?php echo esc_html($slide["card_description"]); ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($slide["card_bottom_content"]) && !empty( $show_bottom_content )): ?>
                            <div class="cards-bottom-content-wrapper">
                                <p><?php echo esc_html( $slide["card_bottom_content"]); ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($slide["card_button_text"]) && !empty($show_btn)): ?>
                            <div class="cards-button-wrapper">
                                <a href="<?php echo esc_url( $slide["card_button_url"]["url"] ); ?>" class="card-button"><?php echo esc_html( $slide["card_button_text"]); ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-pagination"></div>
                <?php if ($settings["show_arrows"] === "yes"): ?>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <?php endif; ?>
            </div>
            <script>
            jQuery(document).ready(function($) {
                var swiper = new Swiper('.swiper-container', {
                    loop: <?php echo esc_attr($loop); ?>,
                    spaceBetween: 30,
                    autoplay: <?php echo esc_attr($autoplay); ?>,
                    slidesPerView: <?php echo esc_attr($slides_to_show); ?>,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                });
            });
            </script>
            <?php elseif ("grid" === $view_type): ?>
            <!-- Grid view -->
            <div class="grid-container">
                <div class="grid-wrapper">
                    <?php foreach ($cards as $grid): ?>
                    <div class="grid-item card-box-container">
                        <?php if (!empty($grid["card_image"]["url"]) && !empty($show_image_logo)): ?>
                            <div class="cards-image-wrapper">
                                <img src="<?php echo esc_url($grid["card_image"]["url"]); ?>"
                                    alt="<?php echo esc_attr($grid["card_title"]); ?>"
                                    style="<?php echo esc_attr($img_size_custom_css); ?>"
                                    >
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($grid["card_title"]) && !empty($show_title)): ?>
                            <div class="cards-title-wrapper">
                                <h3><?php echo esc_html($grid["card_title"]); ?></h3>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($grid["card_subtitle"]) && !empty($show_sub_title)): ?>
                            <div class="cards-subtitle-wrapper">
                                <h4><?php echo esc_html($grid["card_subtitle"]); ?></h4>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($grid["card_description"]) && !empty($show_description)): ?>
                            <div class="cards-description-wrapper">
                                <p> <?php echo esc_html($grid["card_description"]); ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($grid["card_bottom_content"]) && !empty($show_bottom_content)): ?>
                            <div class="cards-bottom-content-wrapper">
                                <p><?php echo esc_html($grid["card_bottom_content"]); ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($grid["card_button_text"]) && !empty($show_btn)): ?>
                            <div class="cards-button-wrapper">
                                <a href="<?php echo esc_url(
                                    $grid["card_button_url"]["url"]
                                ); ?>"
                                    class="card-button"><?php echo esc_html(
                                        $grid["card_button_text"]
                                    ); ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
                <?php endif; ?>
        </div>
    <?php
    }
}
