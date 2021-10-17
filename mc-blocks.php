<?php
/*
Plugin Name: MC Blocks
Text Domain: mc-blocks
*/

use Carbon_Fields\Block;
use Carbon_Fields\Field;
 
defined( 'ABSPATH' ) || exit;


function mc_blocks_load() {
	require_once( 'vendor/autoload.php' );
	\Carbon_Fields\Carbon_Fields::boot();
}
add_action( 'after_setup_theme', 'mc_blocks_load' );
 

/**
 * Bloco para simulação de financiamento
 * Bootstrap 4
 */
function simulacao_financiamento()
{
	Block::make( 'Simulação Financiamento' )
		->add_fields( array(
			Field::make( 'text', 'titulo', 'Nome da linha de financiamento' ),
			Field::make( 'number', 'taxa', 'Taxa' )
		) )
		->set_description( __( 'Bloco para permitir que os usuários façam uma simulação de financiamento.' ) )
		->set_category( 'common' )
		->set_icon( 'calculator' )
		->set_style( 'mc-block-stylesheet' )
		->set_render_callback( function ( $block ) {
 
			ob_start();
			?>

		<div class="simulacao mb-5">
			<div class="pb-5 pt-5 txt-leitura bg-claro">
				<div class="container-fluid">
					<div class="row mt-5 mb-5">
						<div class="col-md-4 offset-md-2">
							<h2>Faça agora a<br>sua simulação</h2>
							<p id="txt-linha-selecionada" style="width: 250px; padding-top: 20px;">
								Com a <?php echo esc_html( $block['titulo'] ); ?> a taxa de juros é de
							</p>
							<h1 id="txt-taxa-juros" style=""><?php echo esc_html( $block['taxa'] ); ?>% a.m.</h1>
						</div>					
						<div class="col-md-4">
							<form id="form-simulacao">
								<input class="form-control inputVlr" type="text" placeholder="Valor do Empréstimo">
								<input class="form-control parcelas" type="text" placeholder="Parcelas">
							</form>
							<p class="txt-auxiliar-resultado"></p>
							<h1 id="txt-resultado"></h1>
						</div>
						<script>
							
						</script>
					</div>
				</div>
			</div> 
		</div>
 
			<?php
 
			return ob_get_flush();
		} );
}
add_action( 'carbon_fields_register_fields', 'simulacao_financiamento' );


/**
 * Bloco para simulação de financiamento - fundo colorido
 */
/* function bgcolor_simulacao_financiamento()
{

}
add_action( 'carbon_fields_register_fields', 'bgcolor_simulacao_financiamento' ); */



/* function simulacao_attach_theme_options() {
	Block::make( 'Simulação' )
		->add_fields( array(
			Field::make( 'text', 'titulo', 'Nome da linha de financiamento' ),
			Field::make( 'rich_text', 'descricao', 'Descrição' ),
			Field::make( 'number', 'taxa', 'Taxa' )
		) )
		->set_render_callback( function ( $block ) {
 
			ob_start();
			?>

            <script>
                alert('Aqui entra o código JS!!!!!');
            </script>
 
			<div class="block">
				<div class="block__heading">
					<h2><?php echo esc_html( $block['titulo'] ); ?></h2>
				</div><!-- /.block__heading -->
 
				<div class="block__descricao">
                    <?php echo apply_filters( 'the_content', $block['descricao'] ); ?>
				</div><!-- /.block__content -->

                <div class="block__taxa">
					<p><strong><?php echo esc_html( $block['taxa'] ); ?></strong></p>
				</div><!-- /.block__heading -->
			</div><!-- /.block -->
 
			<?php
 
			return ob_get_flush();
		} );
}
add_action( 'carbon_fields_register_fields', 'simulacao_attach_theme_options' ); */


