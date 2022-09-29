<?php

/**
 * Template Chooser Widget
 *
 * @package           Template Chooser Widget
 * @author            Zain Hassan
 *
 */
   


/**
 * Elementor List Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class custom_template_chooser_widget extends \Elementor\Widget_Base {

	public function get_style_depends() {

		wp_register_style( 'template_widget_css', plugins_url( 'assets/style1.css', __FILE__ ) );

		return [
            'template_widget_css'
		];

	}


	/**
	 * Get widget name.
	 *
	 * Retrieve company widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'Template Chooser';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve company widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Template Chooser', 'template-chooser-widget' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve company widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-wordpress';
	}

	/**
	 * Get custom help URL.
	 *
	 * Retrieve a URL where the user can get more information about the widget.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget help URL.
	 */
	public function get_custom_help_url() {
		return 'https://developers.elementor.com/widgets/';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the company of categories the company widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'favorites' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the company of keywords the company widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'template chooser', 'template', 'chooser' ];
	}

	public function options(){
		$options = get_option( 'template_chooser_widget' );
		$cats = [];
		foreach($options['frame_repeater'] as $option){
			$cats[preg_replace('/\s+/', '', $option['frame-category'])] = $option['frame-category'];
		}
		return $cats;
	}


	/**
	 * Register company widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {



		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Template Chooser Widget', 'template-chooser-widget' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'list_title', [
				'label' => esc_html__( 'Title', 'template-chooser-widget' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Choose Your Border Design', 'template-chooser-widget' ),
				'label_block' => true,
			]
		);


		$this->add_control(
			'list_content', [
				'label' => esc_html__( 'Content', 'template-chooser-widget' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => "<b>Unlimited Print Booth</b> included either a 2×6 Strip, 4×6 Postcard Print, or Monogram/Logos.<br>  
                <b>Digital &amp; 360 Video Booth</b> please choose a Square  or Monogram / Logos.<br> 
                <b>Glam Booth</b> please choose Monogram / Logos Design",
				'show_label' => false,
			]
		);


		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'tab_title', [
				'label' => esc_html__( 'Tab Title', 'template-chooser-widget' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '2x6 Strips' , 'template-chooser-widget' ),
				'label_block' => true,
			]
		);

        $repeater->add_control(
			'section_title', [
				'label' => esc_html__( 'Section Title', 'template-chooser-widget' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Choose Your Photo Border' , 'template-chooser-widget' ),
				'label_block' => true,
			]
		);

        $repeater->add_control(
			'section_subtitle', [
				'label' => esc_html__( 'Section Sub Title', 'template-chooser-widget' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Which Template Would You Like' , 'template-chooser-widget' ),
				'label_block' => true,
			]
		);

        $repeater->add_control(
			'photo_border', [
				'label' => esc_html__( 'Border', 'template-chooser-widget' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Photo Border' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'frames_category',
			[
				'label' => esc_html__( 'Frames Category', 'template-chooser-widget' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => $this->options(),
			]
		);

        $repeater->add_control(
			'images_column',
			[
				'label' => esc_html__( 'Columns', 'template-chooser-widget' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '2',
				'options' => [
					'2'  => esc_html__( 'Two', 'template-chooser-widget' ),
					'3' => esc_html__( 'Three', 'template-chooser-widget' ),
				],
			]
		);

		$this->add_control(
			'list',
			[
				'label' => esc_html__( 'Repeater List', 'template-chooser-widget' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'tab_title' => esc_html__( '2x6 Strips' , 'template-chooser-widget' )
					]
				],
				'title_field' => '{{{ tab_title }}}',
			]
		);

		$this->add_control(
			'hremail',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'widget_email',
			[
				'label' => esc_html__( 'Email', 'template-chooser-widget' ),
				'label_block' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( get_option( 'admin_email' ), 'template-chooser-widget' ),
				'placeholder' => esc_html__( 'Type your title here', 'template-chooser-widget' ),
			]
		);

		$this->add_control(
			'popup_text', [
				'label' => esc_html__( 'Popup Text', 'template-chooser-widget' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Your Design Has Been Submitted' , 'template-chooser-widget' ),
				'label_block' => true,
			]
		);


		$this->end_controls_section();

        $this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__( 'Style', 'template-chooser-widget' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
                'label' => esc_html__( 'Title Typography', 'template-chooser-widget' ),
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} #template_chooser_widget .heading3',
                'label_block' => true,
			]
		);

        $this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title Color', 'template-chooser-widget' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #template_chooser_widget .heading3' => 'color: {{VALUE}}',
				],
                'label_block' => true,
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
                'label' => esc_html__( 'Content Typography', 'template-chooser-widget' ),
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}} #template_chooser_widget .contentp',
                'label_block' => true,
			]
		);

        $this->add_control(
			'content_color',
			[
				'label' => esc_html__( 'Content Color', 'template-chooser-widget' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #template_chooser_widget .contentp' => 'color: {{VALUE}}',
				],
                'label_block' => true,
			]
		);


        $this->add_control(
			'more_options',
			[
				'label' => esc_html__( 'Main Section Options', 'template-chooser-widget' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
                'label' => esc_html__( 'Tab Title Typography', 'template-chooser-widget' ),
				'name' => 'section_tab_typography',
				'selector' => '{{WRAPPER}} #template_chooser_widget .tabs .tab button',
                'label_block' => true,
			]
		);

        $this->add_control(
			'section_tab_color',
			[
				'label' => esc_html__( 'Tab Title Color', 'template-chooser-widget' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #template_chooser_widget .tabs .tab button' => 'color: {{VALUE}}',
				],
                'label_block' => true,
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
                'label' => esc_html__( 'Section Title Typography', 'template-chooser-widget' ),
				'name' => 'section_title_typography',
				'selector' => '{{WRAPPER}} #template_chooser_widget .section_title',
                'label_block' => true,
			]
		);

        $this->add_control(
			'section_title_color',
			[
				'label' => esc_html__( 'Section Title Color', 'template-chooser-widget' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #template_chooser_widget .section_title' => 'color: {{VALUE}}',
				],
                'label_block' => true,
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
                'label' => esc_html__( 'Section SubTitle Typography', 'template-chooser-widget' ),
				'name' => 'section_subtitle_typography',
				'selector' => '{{WRAPPER}} #template_chooser_widget .tabs-content .text',
                'label_block' => true,
			]
		);

        $this->add_control(
			'section_subtitle_color',
			[
				'label' => esc_html__( 'Section SubTitle Color', 'template-chooser-widget' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #template_chooser_widget .tabs-content .text' => 'color: {{VALUE}}',
				],
                'label_block' => true,
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
                'label' => esc_html__( 'Image Title Typography', 'template-chooser-widget' ),
				'name' => 'section_imgtitle_typography',
				'selector' => '{{WRAPPER}} #template_chooser_widget .tabs-content .items .title',
                'label_block' => true,
			]
		);

        $this->add_control(
			'section_imgtitle_color',
			[
				'label' => esc_html__( 'Image Title Color', 'template-chooser-widget' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #template_chooser_widget .tabs-content .items .title' => 'color: {{VALUE}}',
				],
                'label_block' => true,
			]
		);

        $this->add_control(
			'section_imgtitlebg_color',
			[
				'label' => esc_html__( 'Image Title Background Color', 'template-chooser-widget' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #template_chooser_widget .tabs-content .items .title' => 'background-color: {{VALUE}}',
				],
                'label_block' => true,
			]
		);

		$this->end_controls_section();


	}

	/**
	 * Render company widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
    $settings = $this->get_settings_for_display();
	$options = get_option( 'template_chooser_widget' );



      ?>
        <div id="template_chooser_widget" data-email="<?php echo $settings['widget_email']; ?>">
            <h3 class="heading3"><?php echo $settings['list_title']; ?></h3>
            <p class="contentp">
              <?php echo $settings['list_content']; ?>
            </p>
            <div class="tabs">
                <?php
                    if ( $settings['list'] ) {
                        foreach(  $settings['list'] as $key => $item ){
                            ?>
                            <div class="tab <?php echo  $key == 0 ? "active1" : ""; ?>" data-tab="<?php echo preg_replace('/\s+/', '', $item['tab_title']); ?>">
                                <button><?php echo $item['tab_title']; ?></button>
                            </div>
                            <?php
                        }
                    }
                ?>
            </div>
            <div class="tabs-content">
                <?php
                if( $settings['list'] ){
                    foreach(  $settings['list'] as $key => $item ){
                        ?>
                        <div class="tab <?php echo  $key == 0 ? "active" : ""; ?>" data-tab="<?php echo preg_replace('/\s+/', '', $item['tab_title']); ?>">
                            <button><?php echo $item['tab_title']; ?></button>
                        </div>
                        <div id="<?php echo preg_replace('/\s+/', '', $item['tab_title']); ?>" class="content-tabs <?php echo  $key != 0 ? "d-none" : ""; ?>">
                            <h3 class="section_title">
                                <?php echo $item['section_title']; ?>
                            </h3>
                            <div class="levels">
                                <div class="one step filled">1</div>
                                <div class="two step">2</div>
                            </div>
                            <div class="text" ><?php echo $item['section_subtitle']; ?></div>
                            <div class="span"><?php echo $item['photo_border']; ?></div>
                            <div class="items" style="grid-template-columns: repeat(<?php echo $item['images_column']; ?>, minmax(0, 1fr));">
                                <?php

								foreach($options['frame_repeater'] as $option){

									if($item['frames_category'] == preg_replace('/\s+/', '', $option['frame-category'])){
										$gallery_opt = $option['frame-images']; // for eg. 15,50,70,125
										$gallery_ids = explode( ',', $gallery_opt );
	
										if ( ! empty( $gallery_ids ) ) {
											foreach ( $gallery_ids as $gallery_item_id ) {
												?>
												<div class="item">
													<div class="img">
														<img src="<?php echo wp_get_attachment_url( $gallery_item_id ); ?>" alt="<?php echo get_post_meta($gallery_item_id, '_wp_attachment_image_alt', TRUE); ?>">
													</div>
													<div class="title <?php echo wp_get_attachment_caption( $gallery_item_id )?>"><?php echo get_post_meta($gallery_item_id, '_wp_attachment_image_alt', TRUE); ?></div>
												</div>
												<?php
											}
										}	
									}
								}
                                ?>
                            </div>
                            <div class="form_data d-none">
                                <form  method="POST" action="" enctype="multipart/form-data">
                                    <div class="row-1">
                                        <span class="yourname generic">
                                            <label for="fullname">Your Name<span class="required">*</span></label>
                                            <input id="fullname" type="text" required>
                                        </span>
                                        <span class="booking generic">
                                            <label for="bookingemail">Booking Email<span class="required">*</span></label>
                                            <input id="booking_email" type="email" required>
                                        </span>
                                    </div>
                                    <div class="row-2">
                                        <span class="date generic">
                                            <label for="eventdate">Event Date</label>
                                            <input id="eventdate" type="date">
                                        </span>
                                        <span class="phone generic">
                                            <label for="phoneno">Your Phone<span class="required">*</span></label>
                                            <input id="telphone_no" type="tel" required>
                                        </span>
                                    </div>
                                    <div class="row-3">
                                        <div class="description">
                                            <label for="detail">Border Text & Additional Design Details</label>
                                            <textarea name="detail" id="text_message" rows="4"></textarea>
                                        </div>
                                        <div class="fileimg">
                                            <label for="fileimg">File Upload: .jpg or .png</label>
                                            <input type="file" accept="image/*" id="fileimg" name="fileimg">
                                        </div>
                                    </div>
                                    <div class="row-4">
                                        <button type="button" class="prev">Previous</button>
										<img class="pre_loader d-none" src="<?php echo plugin_dir_url(__FILE__) . 'assets/1amw.gif';?>" alt="preloader" style="width: 30px;height: 30px;" >
                                        <button type="submit" name="submit" value="Upload" class="submit">Submit Design</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
				<div id="template_popup_message" class="d-none">
					<div class="all_set">
						<svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#f2295b " stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
						<p><?php echo $settings['popup_text']; ?></p>
					</div>
				</div>
            </div>
        </div>
      <?php
  }

}