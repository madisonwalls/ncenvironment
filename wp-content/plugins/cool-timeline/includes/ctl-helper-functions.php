<?php
function ctl_custom_style()
{
            
            $ctl_options_arr = get_option('cool_timeline_options');
            $disable_months =isset($ctl_options_arr['disable_months'])?$ctl_options_arr['disable_months']:"no";
            $title_alignment =isset($ctl_options_arr['title_alignment'])?$ctl_options_arr['title_alignment']:"center";
        
            /*
             * Style options
             */
           
            $background_type =isset($ctl_options_arr['background']['enabled'])?$ctl_options_arr['background']['enabled']:'';
            $first_post_color=isset($ctl_options_arr['first_post'])?$ctl_options_arr['first_post']:"#29b246";
            $second_post_color=isset($ctl_options_arr['second_post'])?$ctl_options_arr['second_post']:"#ce792f";
            $bg_color = isset($ctl_options_arr['background']['bg_color'])?$ctl_options_arr['background']['bg_color']:'none';
           
            $content_bg_color = isset($ctl_options_arr['content_bg_color'])?$ctl_options_arr['content_bg_color']:'#fff';
            $cont_border_color =isset( $ctl_options_arr['circle_border_color'])? $ctl_options_arr['circle_border_color']:'#38aab7';
             $custom_styles ='';
             $custom_styles = isset( $ctl_options_arr['custom_styles'])?$ctl_options_arr['custom_styles']:"no";

             /*
             * Typography options
             */
            $ctl_main_title_typo = $ctl_options_arr['main_title_typo'];
            $ctl_post_title_typo = $ctl_options_arr['post_title_typo'];
            $ctl_post_content_typo = $ctl_options_arr['post_content_typo'];
            
            $post_title_text_style = $ctl_options_arr['post_title_text_style'];
 
            
            $main_title_f=isset($ctl_main_title_typo['face']) ? $ctl_main_title_typo['face'] : 'inherit';
           $main_title_w=isset($ctl_main_title_typo['weight']) ? $ctl_main_title_typo['weight'] : 'inherit';
           $main_title_s=isset($ctl_main_title_typo['size']) ? $ctl_main_title_typo['size'] : '22px';

            $events_body_f=isset($ctl_post_content_typo['face'])?$ctl_post_content_typo['face']:'inherit';
            $events_body_w=isset($ctl_post_content_typo['weight'])?$ctl_post_content_typo['weight']:'inherit';
            $events_body_s=isset($ctl_post_content_typo['size'])?$ctl_post_content_typo['size']:'inherit';

            $post_title_f=isset($ctl_post_title_typo['face'])?$ctl_post_title_typo['face']:'inherit';
            $post_title_w=isset($ctl_post_title_typo['weight'])?$ctl_post_title_typo['weight']:'inherit';
            $post_title_s=isset($ctl_post_title_typo['size'])?$ctl_post_title_typo['size']:'inherit';

            $post_content_f=isset($ctl_post_content_typo['face'])?$ctl_post_content_typo['face']:'inherit';
            $post_content_w=isset($ctl_post_content_typo['weight'])?$ctl_post_content_typo['weight']:'inherit';
            $post_content_s=isset($ctl_post_content_typo['size'])?$ctl_post_content_typo['size']:'inherit';
            
            //line_type = $ctl_options_arr['line_type'];
            $line_color =isset($ctl_options_arr['line_color'])?$ctl_options_arr['line_color']:'#025149';
              $styles = '';
        
            if ($background_type == 'on') {
                $styles.='.cool_timeline.cool-timeline-wrapper {background:'.$bg_color.';}';
            }
            
            $styles.=' 
            .cool_timeline h1.timeline-main-title {
                font-weight:'.$main_title_w.'!important;
                font-family:'.$main_title_f.'!important;
                font-size:'.$main_title_s.'!important;
                text-align:'.$title_alignment.'!important;
            } 
            .cool_timeline h4.timeline-main-title.center-block{
                font-weight:'.$main_title_w.'!important;
                font-family:'.$main_title_f.'!important;
                font-size:'.$main_title_s.'!important;
                text-align:'.$title_alignment.'!important;
            }';

   if($line_color){
        $styles.=' .cool-timeline.white-timeline:before, .cool-timeline.white-timeline.one-sided:before {
    background-color:'.$line_color.';
    background-image: -webkit-linear-gradient(top,'.$line_color.' 0%, '.$line_color.' 8%, '.$line_color.' 92%, '.$line_color.' 100%);
    background-image: -moz-linear-gradient(top, '.$line_color.' 0%, '.$line_color.' 8%, '.$line_color.' 92%, '.$line_color.' 100%);
    background-image: -ms-linear-gradient(top, '.$line_color.' 0%, '.$line_color.' 8%, '.$line_color.' 92%, '.$line_color.' 100%);
    }';
  
    $styles.=' .cool-timeline.white-timeline .timeline-year{
        -webkit-box-shadow: 0 0 0 4px white, inset 0 0 0 2px rgba(0, 0, 0, 0.05), 0 0 0 8px '.$line_color.';
        box-shadow: 0 0 0 4px white, inset 0 0 0 2px rgba(0, 0, 0, 0.05), 0 0 0 8px '.$line_color.';
    }';
        
    $styles.='.cool-timeline.white-timeline .timeline-post .iconbg-turqoise{
         box-shadow: 0 0 0 4px white, inset 0 0 0 2px #fff, 0 0 0 8px '.$line_color.';
        }';

    $styles.='.cool-timeline.white-timeline.compact .timeline-post .icon-color-white {
        box-shadow: 0px 0px 0 3px '.$line_color.' !Important;
        }
        .cooltimeline_cont .center-line:before,.cooltimeline_cont .center-line:after{
        border-color:'.$line_color.';
        }.cooltimeline_cont .center-line{
        background:'.$line_color.';
        }';

   }     
if($cont_border_color){   
  $styles.=' .cool-timeline.white-timeline .timeline-year{
            background:'.$cont_border_color.';
        }';
    }
 if($content_bg_color){       
$styles.='
 .cool-timeline .timeline-post .timeline-content {
    background:'.$content_bg_color.';
}';
 }
if($post_title_f){
 $styles.=' .cool-timeline .timeline-year .icon-placeholder span {
                font-family:'.$post_title_f.'!important;
            }';
}

$styles.='
 .cool-timeline .timeline-post .timeline-content h2.content-title{
    font-size:'.$post_title_s.'!important;
    font-family:'.$post_title_f.'!important;
    font-weight:'.$post_title_w.'!important;
    text-transform:'.$post_title_text_style.';
}';
$styles.=' .cool-timeline .timeline-post .timeline-content .content-details{
    font-size:'.$post_content_s.'!important;
    font-family:'.$post_content_f.'!important;
    font-weight:'.$post_content_w.'!important;
}';

$styles.='.cool-timeline .timeline-post .timeline-meta .meta-details{
    font-family:'.$post_title_f.'!important;
    font-weight:'.$post_title_w.'!important;
}';

if($first_post_color){
    $styles.='.cool-timeline.white-timeline .timeline-post.even .timeline-content .content-title:before{
        border-right-color:'.$first_post_color.';
    }

    .cool-timeline.white-timeline.one-sided .timeline-post.even .timeline-content .content-title:before {
        border-right-color:'.$first_post_color.';
    }';

    $styles.='
    .cool-timeline.white-timeline  .timeline-post.even .icon-dot-full, .cool-timeline.one-sided.white-timeline .timeline-post.even .icon-dot-full{
        background:'.$first_post_color.';
    }';
    $styles.='
    .cool-timeline.white-timeline  .timeline-post.even .icon-color-white, .cool-timeline.one-sided.white-timeline .timeline-post.even .icon-color-white{
        background:'.$first_post_color.';
    } 
    .cool-timeline.white-timeline  .timeline-post.even .timeline-meta .meta-details{
        color:'.$first_post_color.';
    }
    .cool-timeline.white-timeline  .timeline-post.even .timeline-content .content-title{
    background:'.$first_post_color.';
    }
    .clean-skin-tm .cool-timeline.white-timeline  .timeline-post.even .timeline-content h2.content-title{
        color:'.$first_post_color.';
    }
    .clean-skin-tm .cool-timeline.white-timeline.compact  .timeline-post.ctl-left .timeline-content h2.content-title{
    color:'.$first_post_color.';
    }
    .clean-skin-tm .cool-timeline.white-timeline.compact  .timeline-post.ctl-left .timeline-content {
    border-right:3px solid '.$first_post_color.';
    border-radius:0;
}
.cool-timeline.white-timeline.compact .timeline-post.ctl-left .icon-dot-full{
  background:'.$first_post_color.';
}
  ';
    /*
    compact timeline styles:
     */
    $styles.='.ultimate-style .timeline-post.timeline-mansory.ctl-left .timeline-content .content-title:after {
        border-left-color:'.$first_post_color.';
    }
    .cool-timeline.white-timeline.compact  .timeline-post.ctl-left .timeline-content .content-title,.cool-timeline.white-timeline.compact .timeline-post.ctl-left .icon-color-white{
    background:'.$first_post_color.';
}
 
    ';
}

if($second_post_color){
    $styles.='.cool-timeline.white-timeline .timeline-post.odd .timeline-content .content-title:before{
        border-left-color:'.$second_post_color.';
    }
    .cool-timeline.white-timeline.one-sided .timeline-post.odd .timeline-content .content-title:before {
        border-right-color:'.$second_post_color.';
        border-left-color: transparent;
    }';

    $styles.='
    .cool-timeline.white-timeline  .timeline-post.odd .icon-dot-full, .cool-timeline.one-sided.white-timeline .timeline-post .icon-dot-full{
      background:'.$second_post_color.';
    }';
    $styles.='
    .cool-timeline.white-timeline  .timeline-post.odd .icon-color-white, .cool-timeline.one-sided.white-timeline .timeline-post .icon-color-white{
      background:'.$second_post_color.';
    }';
    $styles.='

    .cool-timeline.white-timeline  .timeline-post.odd .timeline-meta .meta-details{
        color:'.$second_post_color.';
    }';
    $styles.='
    .cool-timeline.white-timeline  .timeline-post.odd .timeline-content .content-title {
        background:'.$second_post_color.';
    }

    .clean-skin-tm .cool-timeline.white-timeline  .timeline-post.odd .timeline-content h2.content-title {
        color:'.$second_post_color.';
    }

    .clean-skin-tm .cool-timeline.white-timeline.compact  .timeline-post.ctl-right .timeline-content h2.content-title {
        color:'.$second_post_color.';
    }
    .clean-skin-tm .cool-timeline.white-timeline.compact  .timeline-post.ctl-right .timeline-content {
        border-left:3px solid '.$second_post_color.';
        border-radius:0;
    }
   .ultimate-style .timeline-post.timeline-mansory.ctl-right .timeline-content .content-title:after{
            border-right-color:'.$second_post_color.';
    }

   .cool-timeline.white-timeline.compact  .timeline-post.ctl-right .timeline-content .content-title,.cool-timeline.white-timeline.compact .timeline-post.ctl-right .icon-color-white {
    background:'.$second_post_color.';
}

.cool-timeline.white-timeline.compact .timeline-post.ctl-right .icon-dot-full{
  background:'.$second_post_color.';
} ';

}
 $styles.='@media (max-width: 860px) {
    .clean-skin-tm .cool-timeline.white-timeline.compact  .timeline-post.ctl-left.even .timeline-content h2.content-title{
    color:'.$first_post_color.';
} 
.clean-skin-tm .cool-timeline.white-timeline.compact  .timeline-post.ctl-left.odd .timeline-content h2.content-title {
    color:'.$second_post_color.';
}
}
';


$styles.='
.cool-timeline.white-timeline.compact  .timeline-post .timeline-content h2.content-title{
   font-size:'.$post_title_s.'!important;
    font-family:'.$post_title_f.'!important;
    font-weight:'.$post_title_w.'!important;
}';

$styles.='
@media (max-width: 860px) {
.cool-timeline.white-timeline .timeline-post.odd .timeline-content .content-title:before {
    border-right-color:'.$second_post_color.';
    border-left-color: transparent;
}
.cool-timeline.white-timeline.compact  .timeline-post.ctl-left.even .timeline-content .content-title,.cool-timeline.white-timeline.compact .timeline-post.ctl-left.even .icon-color-white, .cool-timeline.white-timeline.compact .timeline-post.ctl-left.even .icon-dot-full{
    background:'.$first_post_color.';
}
.cool-timeline.white-timeline.compact  .timeline-post.ctl-left.odd .timeline-content .content-title,.cool-timeline.white-timeline.compact .timeline-post.ctl-left.odd .icon-color-white, .cool-timeline.white-timeline.compact .timeline-post.ctl-left.odd .icon-dot-full{
    background:'.$second_post_color.';
}
.ultimate-style .timeline-post.timeline-mansory.ctl-left .timeline-content .content-title:after {
border-left-color:transparent;}

}';

    $styles.='   /*-----Custom CSS-------*/';
    $styles.=$custom_styles;
    wp_add_inline_style( 'ctl_styles',clt_minify_css($styles) );

 }

    function clt_minify_css($css){
         $buffer = $css;
          // Remove comments
          $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
          // Remove space after colons
         $buffer = str_replace(': ', ':', $buffer);
          // Remove whitespace
        $buffer = str_replace(array("\r\n", "\r", "\n", "\t"), '', $buffer);
        $buffer = preg_replace(" {2,}", ' ',$buffer);
          // Write everything out
        return $buffer;
         }
        
function ctl_pagination($numpages = '', $pagerange = '', $paged='') {
 if (empty($pagerange)) {
    $pagerange = 2;
    }

 if ( get_query_var('paged') ) { 
            $paged = get_query_var('paged'); 
            } elseif ( get_query_var('page') ) { 
            $paged = get_query_var('page'); 
            } else { 
            $paged = 1; 
            }
     if ($numpages == '') {

        global $wp_query;

        $numpages = $wp_query->max_num_pages;

        if(!$numpages) {
             $numpages = 1;
            }
        }

     $big = 999999999; 
     $of_lbl = __( ' of ', 'cool-timeline' ); 
    $page_lbl = __( ' Page ', 'cool-timeline' ); 
 $pagination_args = array(
    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
     'format' => '?paged=%#%',
    'total'           => $numpages,
     'current'         => $paged,
     'show_all'        => False,
    'end_size'        => 1,
    'mid_size'        => $pagerange,
    'prev_next'       => True,
    'prev_text'       => __('&laquo;'),
    'next_text'       => __('&raquo;'),
    'type'            => 'plain',
     'add_args'        => false,
    'add_fragment'    => '' );
 $paginate_links = paginate_links($pagination_args);
 $ctl_pagi='';
    if ($paginate_links) {
        $ctl_pagi .= "<nav class='custom-pagination'>";
     $ctl_pagi .= "<span class='page-numbers page-num'> ".$page_lbl . $paged . $of_lbl . $numpages . "</span> ";
        $ctl_pagi .= $paginate_links;
         $ctl_pagi .= "</nav>";
        return $ctl_pagi;
 }

}