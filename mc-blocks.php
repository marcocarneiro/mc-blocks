<?php
/*
Plugin Name: MC Blocks
Text Domain: mc-blocks
*/

use Carbon_Fields\Block;
use Carbon_Fields\Field;
use Carbon_Fields\Container;

 
defined( 'ABSPATH' ) || exit;


function mc_blocks_load() {
	require_once( 'vendor/autoload.php' );
	\Carbon_Fields\Carbon_Fields::boot();
}
add_action( 'after_setup_theme', 'mc_blocks_load' );

//Função geradora de SLUGS para utilizar em atributos ID
function slugify($text)
{
  // replace non letter or digits by -
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);
  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);
  // trim
  $text = trim($text, '-');
  // remove duplicate -
  $text = preg_replace('~-+~', '-', $text);
  // lowercase
  $text = strtolower($text);
  if (empty($text)) {
    return 'n-a';
  }

  return $text;
}


/**
 * Bloco imagem abre vídeo em janela modal
 */
function imagem_videomodal()
{
	Block::make( 'MC vídeo modal' )
		->add_fields( array(
			Field::make( 'text', 'incorporacao', __( 'Código de incorporação (Youtube ou Vimeo)' ) ),
			Field::make( 'image', 'image', __( 'Imagem primeiro frame' ) ),
		) )
		->set_description( __( 'Bloco de imagem que abre um vídeo num modal.' ) )
		->set_category( 'custom-category', __( 'MC Blocks' ), 'smiley' )
		->set_icon( 'media-video' )
		->set_render_callback( function ( $block ) {
 
			ob_start();
			?>
			
			<figure class="mcblocks-videomodal wp-block-image size-full clickable" 
			onclick="abreModal('<?php echo esc_html( $block['incorporacao'] ); ?>')">
				<?php echo wp_get_attachment_image( $block['image'], 'full' ); ?>
			</figure>					
 
			<?php
 
			return ob_get_flush();
		} );
}
add_action( 'carbon_fields_register_fields', 'imagem_videomodal' );



/**
 * Bloco para vídeo em fullscreen
 */
function video_background()
{
	Block::make( 'MC Vídeo Background' )
		->add_fields( array(
			Field::make( 'image', 'url_video', __( 'Vídeo' ) )->set_type( array( 'image', 'video' ) ),
			Field::make( 'rich_text', 'content', __( 'Conteúdo' ) ),
		) )
		->set_description( __( 'Bloco para vídeo fullscreen formato mp4 - arquivo deverá estar na biblioteca.' ) )
		->set_category( 'custom-category', __( 'MC Blocks' ), 'smiley' )
		->set_icon( 'format-video' )
		->set_render_callback( function ( $block ) {
 
			ob_start();
				?>

				<?php 
					$url = wp_get_attachment_url( $block['url_video'] );
					$imgsrc = esc_html( $url );
				?>

				<div class="mcblocks-videofullscreen">
					<video src="<?php echo $imgsrc ?>" muted="" loop="" autoplay=""></video>
					<div class="content" data-aos="fade-right" data-aos-duration="1000" data-aos-delay="1000">
						<?php echo apply_filters( 'the_content', $block['content'] ); ?>
					</div>
				</div>

				<?php 
			return ob_get_flush();
	} );
}
add_action( 'carbon_fields_register_fields', 'video_background' );


/**
 * Bloco para simulação de financiamento
 * Bootstrap 5
 */
function simulacao_financiamento()
{
	Block::make( 'Simulação Financiamento' )
		->add_fields( array(
			Field::make( 'text', 'titulo', 'Nome da linha de financiamento' ),
			Field::make( 'number', 'taxa', 'Taxa' ),
			Field::make( 'number', 'limite', 'Limite de parcelas' )
		) )
		->set_description( __( 'Bloco para permitir que os usuários façam uma simulação de financiamento.' ) )
		->set_category( 'custom-category', __( 'MC Blocks' ), 'smiley' )
		->set_icon( 'calculator' )
		->set_render_callback( function ( $block ) {
 
			ob_start();
			?>
				<form id="mcblocks-form-simulacao">
					<input class="form-control mb-5 inputVlr" id="mcblocks-valor" type="text" placeholder="Valor do Empréstimo">
					<input class="form-control parcelas" id="mcblocks-parcelas" onkeyup="simulacao()" type="text" placeholder="Parcelas">
				</form>
				<p class="text-white" id="mcblocks-txt-auxiliar"></p>
				<h1 id="mcblocks-txt-resultado"></h1>
				<script>					
					function calculaParcela(valor, parcelas, juros) 
					{						
						valor = (valor * 1.00033) * 1.0173;
						resultado = valor * ((Math.pow(1 + juros, parcelas) * juros) / (Math.pow(1 + juros, parcelas) - 1));
						return resultado;
					}
					function simulacao()
					{
						var vlr = Number(document.getElementById('mcblocks-valor').value);
						var parcelas = Number(document.getElementById('mcblocks-parcelas').value);
						if(parcelas > Number(<?php echo $block['limite'] ?>))
						{
							alert('O limite máximo de parcelas é ' + <?php echo $block['limite'] ?> );
							document.getElementById('mcblocks-parcelas').value = '';
						}
						var juros = Number(<?php echo $block['taxa'] ?>)*0.01;
						var result = calculaParcela(vlr, parcelas, juros);
						result = String(result.toFixed(2).replace(".", ","));
						document.getElementById('mcblocks-txt-resultado').innerText = result;
					}
				</script>
 
			<?php 
			return ob_get_flush();
		} );
}
add_action( 'carbon_fields_register_fields', 'simulacao_financiamento' );


/**
 * Bloco para Sliders - carousel
 * Bootstrap 5
 */
function sliders()
{
    Block::make(__('MC Slider Show'))->add_fields(array(
        Field::make('text', 'all_counter_heading', __('Block Title')) ,
        Field::make('complex', 'crb_list_counter', __('Counter'))
            ->set_layout('tabbed-horizontal')
            ->add_fields(array(
            Field::make('image', 'counter_img', 'Imagem')
                ->set_required(true)
                ->set_value_type('url')
                ->set_width(50) ,
            Field::make('text', 'legenda', 'Legenda')
                ->set_width(30) ,

        )) ,

    ))
        ->set_icon('media-interactive')
        ->set_keywords([__('SliderShow') ])
        ->set_description(__('Bloco para criação de SlideShow baseado no componente carousel do Bootstrap.'))
		->set_category( 'custom-category', __( 'MC Blocks' ), 'smiley' )
        ->set_render_callback(function ($fields, $attributes, $inner_blocks)
    {

        //Cria um slug com o título do slideshow
		$id = slugify($fields['all_counter_heading']);

		$counters = $fields['crb_list_counter'];
        if ($counters):			
			echo '<div id="' .$id. '" class="carousel slide" data-bs-ride="carousel">';
			echo '<div class="carousel-indicators">';
				for ($c=0; $c < count($counters); $c++) {
					if($c == 0){
						echo '<button type="button" data-bs-target="#' .$id. '" data-bs-slide-to="' .$c. '" class="active" aria-current="true" aria-label="Slide ' .$c. '"></button>';
					}else{
						echo '<button type="button" data-bs-target="#' .$id. '" data-bs-slide-to="' .$c. '" aria-label="Slide ' .$c. '"></button>';
					}					
				}
			echo '</div>';
			echo '<div class="carousel-inner">';

			$i = 0;
			foreach ($counters as $counter):
                $image_black = $counter['counter_img'];
                $list_counter_tb = $counter['legenda'];
				
				if($i == 0)
				{ 
					echo '<div class="carousel-item active">';
				}else{
					echo '<div class="carousel-item ">';
				}				
				echo '	<img src="'.$counter['counter_img'].'" class="d-block w-100" alt="' .$counter['legenda']. '">';
				echo '	<div class="carousel-caption d-none d-md-block">';
				echo '		<p>' .$counter['legenda']. '</p>';
				echo '	</div>';
				echo '</div>';

				$i ++;
				
			endforeach;
			echo '</div>';

			echo '<button class="carousel-control-prev" type="button" data-bs-target="#' .$id. '" data-bs-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Previous</span>
			</button>
			<button class="carousel-control-next" type="button" data-bs-target="#' .$id. '" data-bs-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Next</span>
			</button>';

			echo '</div>';

        endif;
    });
}
add_action('carbon_fields_register_fields', 'sliders');
