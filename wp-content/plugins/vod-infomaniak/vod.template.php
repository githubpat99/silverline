<?php
	/**
	 * Classe d'affichage regroupant les differents templates html/js
	 * En cas de problemes ou de questions, veuillez contacter support-vod-wordpress@infomaniak.ch
	 *
	 * @author Infomaniak Media team
	 * @link https://www.infomaniak.com
	 * @version 1.4.4
	 * @copyright infomaniak.ch
	 *
	 */
	class EasyVod_Display {

		static function buildForm($options, $aPlayers, $aVideos, $aPlaylists, $aFolders, $bCanUpload) {
			?>
			<link rel='stylesheet' href='<?php echo plugins_url('vod-infomaniak/css/style.css?1'); ?>' media='all' />


            <div id="dialog-vod-logout" style="display:none;" title="<?=__('Probleme de configuration', 'vod_infomaniak')?>">
                <p><?=__("Veuillez-vous rendre dans <a href='admin.php?page=configuration'>Videos -> Configuration</a> afin de configurer votre compte.", 'vod_infomaniak');?></p>
                ?>
            </div>
			<div class="hidden">
                <div id="dialog-vod-form">
					<div id="dialog-tabs" class="ui-tabs">
						<ul class="ui-tabs-nav">
							<li><a href="#dialog-tab2" onclick="Vod_selectTab(2);"><?php _e('Videos', 'vod_infomaniak'); ?></a></li>
							<li><a href="#dialog-tab4" onclick="Vod_selectTab(4);"><?php _e('Playlists', 'vod_infomaniak'); ?></a></li>
							<li><a href="#dialog-tab1" onclick="Vod_selectTab(1);"><?php _e("Avec l'url", 'vod_infomaniak'); ?></a></li>
							<?php if ($bCanUpload) { ?>
								<li><a href="#dialog-tab3" onclick="Vod_selectTab(3);"><?php _e("Envoi d'une video", 'vod_infomaniak'); ?></a></li>
							<?php } ?>
						</ul>
						<input type="hidden" id="dialog-token" value=""/>
						<input type="hidden" id="version" value="<?php echo get_option( 'vod_api_version', false ) ?>"/>

						<div id="dialog-tab1" class="ui-tabs-panel">
							<div style="padding-left: 20px; padding-bottom: 10px;"><?php _e("Veuillez saisir l'URL d'une video", 'vod_infomaniak'); ?></div>
							<div style="padding-left: 20px;">
								<strong><?php _e('Exemple', 'vod_infomaniak'); ?>:</strong>
								<ul id="dialog-exemple">
									<li><?php _e('Url complete', 'vod_infomaniak'); ?>: <code>https://vod.infomaniak.com/redirect/infomaniak_vod1/folder-234/mp4-148/video.mp4</code>
									<li><?php _e('Url partiel', 'vod_infomaniak'); ?>: <code>folder-234/mp4-148/video.mp4</code></li>
									<li><?php _e('Identifiant de playlist', 'vod_infomaniak'); ?>: <code>25</code></li>
								</ul>
							</div>
							<p style="text-align:center"><input type="text" id="dialog-url-input"/></p>
						</div>

						<div id="dialog-tab2" class="ui-tabs-panel" style="height: 450px; overflow-y: scroll;">
							<div style="position: absolute;background-color: white;width: 95%;height: 50px;margin-top: -13px;padding-top: 15px;text-align:center;">
								<input id="vod_infomaniak_search_videos" style="font-size:12px;padding: 3px;border-radius: 2px;height: 35px;text-indent: 5px;width: 100%;" type="search" placeholder="<?php _e("Rechercher ...", 'vod_infomaniak'); ?>"/>
							</div>
							<table class="widefat" style="margin-top:60px;width:100%">
								<thead>
									<tr>
										<th width="110"><?php _e("Video", 'vod_infomaniak'); ?></th>
										<th><?php _e("Nom", 'vod_infomaniak'); ?></th>
										<th width="150"><?php _e("Date d'upload", 'vod_infomaniak'); ?></th>
									</tr>
								</thead>
								<tbody id="vod_infomaniak_videos_container">
									<?php
										if (empty($aVideos)) {
											echo "<option value='0'>" . __("Aucune video disponible", 'vod_infomaniak') . "</option>";
										} else {
											foreach ($aVideos as $oVideo) {
														if (get_option( 'vod_api_version', false ) == 1){
															echo ("<tr class=\"vod_element_select\" onclick=\"Vod_selectVideo(this, '".$oVideo->sPath . $oVideo->sServerCode . "." . strtolower($oVideo->sExtension)."','".$oVideo->sToken ."','".$oVideo->iFolder ."');\"><td>;");

															echo ("<img width='100' src='https://vod.infomaniak.com/redirect/".$options['vod_api_id'] . $oVideo->sPath . $oVideo->sServerCode.".mini.jpg' />");
														}else{
															echo ("<tr class=\"vod_element_select\" onclick=\"Vod_selectVideo(this, '". $oVideo->sServerCode ."','".$oVideo->sToken ."','".$oVideo->iFolder ."');\"><td>");

															echo ("<img width='100' src='".$oVideo->sImageUrlV2."'/>");
														}
														?>
													</td>
													<td style="max-width:400px">
														<?php echo ucfirst(stripslashes($oVideo->sName)); ?><br/><br/>
														<img src="<?php echo plugins_url('vod-infomaniak/img/ico-folder-open-16x16.png'); ?>" style="vertical-align:bottom"/> <?php echo $oVideo->sPath; ?>
													</td>
													<td><?php echo $oVideo->dUpload; ?></td>
												</tr>
									<?php
											}
										}
									?>
								</tbody>
							</table>
						</div>

						<div id="dialog-tab4" class="ui-tabs-panel" style="height: 450px; overflow-y: scroll;">
							<div style="position: absolute;background-color: white;width: 95%;height: 50px;margin-top: -13px;padding-top: 15px;text-align:center;">
								<input id="vod_infomaniak_search_playlists" style="font-size:12px;padding: 3px;border-radius: 2px;height: 35px;text-indent: 5px;width: 100%;" type="search" placeholder="<?php _e("Rechercher ...", 'vod_infomaniak'); ?>"/>
							</div>

							<table class="widefat" style="margin-top:60px;width:100%">
								<thead>
									<tr>
										<th><?php _e("Playlist", 'vod_infomaniak'); ?></th>
										<th><?php _e("Description", 'vod_infomaniak'); ?></th>
										<th width="80"><?php _e("Nbr Videos", 'vod_infomaniak'); ?></th>
										<th width="100"><?php _e("Duree", 'vod_infomaniak'); ?></th>
									</tr>
								</thead>
								<tbody id="vod_infomaniak_playlists_container">
									<?php
										if (empty($aPlaylists)) {
											echo "<option value='0'>" . __("Aucune playlist de disponible", 'vod_infomaniak') . "</option>";
										} else {
											foreach ($aPlaylists as $oPlaylist) {
												$sDuration = "";
												if(!empty($oPlaylist->iTotalDuration)){
													$iDuration = intval($oPlaylist->iTotalDuration/100);
													$iHours = intval($iDuration/3600);
													$iMinutes = intval($iDuration/60) % 60;
													$iSecondes = intval($iDuration) % 60;
													$sDuration .= $iHours > 0 ? $iHours."h. " : '';
													$sDuration .= $iMinutes > 0 ? $iMinutes."m. " : '';
													$sDuration .= $iSecondes > 0 ? $iSecondes."s. " : '';
												}
									?>
									
												<tr class="vod_element_select" onclick="Vod_selectVideo(this, '<?php 
												if (get_option( 'vod_api_version', false ) == 1) {
													echo $oPlaylist->iPlaylistCode; 
												}else{
													echo $oPlaylist->sPlaylistUuid; 
												}
												?>','','');">
													<td><?=ucfirst(stripslashes($oPlaylist->sPlaylistName));?></td>
													<td><?=stripslashes($oPlaylist->sPlaylistDescription);?></td>
													<td align="center"><?=$oPlaylist->iTotal;?></td>
													<td align="right"><?=$sDuration;?></td>
												</tr>
									<?php
											}
										}
									?>
								</tbody>
							</table>
						</div>


						<?php if ($bCanUpload) { 

							header_remove('Access-Control-Allow-Origin');
							header( "Access-Control-Allow-Origin: https://api.vod2.infomaniak.com" );
							header( 'Access-Control-Allow-Credentials: true' );
							header( 'Access-Control-Allow-Methods: GET, POST, OPTIONS' ); 
							header( 'Access-Control-Allow-Headers: X-Requested-With, Content-Type');

//							apply_filters( 'allowed_http_origins', array("https://api.vod2.infomaniak.com","http://toto.com" ));
//							apply_filters( 'allowed_http_origin', "https://api.vod2.infomaniak.com", "https://api.vod2.infomaniak.com" );
							?>
							<div id="dialog-tab3" class="ui-tabs-panel">
								<input type="hidden" id="url_ajax_import_video" value="<?php echo get_bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php?action=vodimportvideo"/>
								<input type="hidden" id="url_ajax_share_link" value="<?php echo get_bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php?action=vodsharelink"/>
								<?php if (get_option( 'vod_api_version', false ) == 1) {
								echo ('<h4 style="margin:0">Merci de proceder a la mise a jour du plugin et de votre compte vod</h4>');
								}else{
								?>
								<h4 style="margin:0"><?php _e('1. Selection du dossier', 'vod_infomaniak'); ?>:</h4>
								<select id="uploadSelectFolder" style="width:550px;" onchange="changeFolderUp1();" onkeyup="changeFolderUp1();">
									<option value="-1" selected="selected">-- <?php _e("Dossier d'envoi", 'vod_infomaniak'); ?> -- </option>
									<?php
										if (empty($aFolders)) {
											echo "<option value='0'>" . __("Aucun dossier disponible", 'vod_infomaniak') . "</option>";
										} else {
											foreach ($aFolders as $oFolder) {
												echo "<option value='" . $oFolder->iFolder . "'>" . __('Dossier', 'vod_infomaniak') . ": /" . $oFolder->sPath . " , " . __('Nom', 'vod_infomaniak') . ": " . $oFolder->sName . "</option>";
											}
										}
									?>
								</select>
								<input class="button" type="button" value="Valider" onclick="Vod_importVideo();return false;"/>

								<div id="vodUploadVideo" style="display:none">
									<br/>
									<h4 style="margin:0"><?php _e("2. Envoi d'un fichier", 'vod_infomaniak'); ?>:</h4>

									<div id="vodUploadLoader">
										<?php
										echo "Chargement... <img src='" . plugins_url('vod-infomaniak/img/ajax-loader.gif') . "' style='vertical-align:bottom'/> ";
										?>										
									</div>
									<div id="vod-up">

									</div>
								</div>
								<div id="vodEncodeVideo" style="display:none">
									<br/>
									<h4 style="margin:0"><?php _e("3. Traitement du fichier", 'vod_infomaniak'); ?>:</h4>

									<div id="vodEncodeLoader">
										<ul>
											<li id="VodEncodeS1" class="vodencode">Fichier reçu</li>
											<li id="VodEncodeS2" class="vodencode"><span id="encodeStep"/>Pre-encodage</span>  <?php echo "<img id='encodeVodLoader' src='" . plugins_url('vod-infomaniak/img/ajax-loader.gif') . "' style='vertical-align:bottom;display:none'/> ";?> <span id="encodeProgress"/></li> 
											<li id="VodEncodeS3" class="vodencode">Au moins un des encodages est disponible *</li>
										</ul>
										<span id="notaDispo" class="vodencode"> * Vous pouvez d'or et déjà intégrer votre vidéo, l'ensemble des encodages sera automatiquement visible une fois disponible</span>
									</div>
								</div>
								<?php } ?>
							</div>
						<?php } ?>
					</div>

					<div id="dialog-config">
						<div id="dialog-slide-header" class="ui-dialog-titlebar" onclick="Vod_dialogToggleSlider();"><?php _e('Options d\'integration', 'vod_infomaniak'); ?></div>
						<div id="dialog-slide" style="display:none">

<p class="dialog-form-line">
							Format du player : <label>
							<input type="radio" name="formatPlayer" id="fixed" onclick="toggleTextFields()" checked>
								Fixe
							</label>
							<label>
							<input type="radio" name="formatPlayer" id="responsive" onclick="toggleTextFields()">
								Responsive
							</label>
							</p>

							<div id="textFields">
								<p class="dialog-form-line">
									<label for="dialog-width-input"><?php _e('Dimensions', 'vod_infomaniak'); ?></label>
									<input type="text" id="dialog-width-input" size="5"/> &#215; <input type="text" id="dialog-height-input" size="5"/> pixels
								</p>
							</div>
							<p class="dialog-form-line">
								<input type="hidden" id="dialog-player-default" value="<?php echo $options['player']; ?>"/>
								<label for="dialog-player"><?php _e('Player choisi', 'vod_infomaniak'); ?></label>
								<select id="dialog-player">
									<?php
										if (empty($aPlayers)) {
											echo "<option value='0'>" . __("Aucun player disponible", 'vod_infomaniak') . "</option>";
										} else {
											foreach ($aPlayers as $player) {
												$selected = "";
												if ($options['player'] == $player->iPlayer) {
													$selected = 'selected="selected"';
												}
												echo "<option value='" . $player->iPlayer . "' $selected>" . ucfirst($player->sName) . "</option>";
											}
										}
									?>
								</select>
							</p>

							<!--<p class="dialog-form-line">
								<label><?php _e('Etirer la video (stretch)', 'vod_infomaniak'); ?></label>
								<input type="checkbox" id="dialog-stretch" checked="checked" value="1"/>
							</p>

							<p class="dialog-form-line">
								<label><?php _e('Demarrage automatique', 'vod_infomaniak'); ?></label>
								<input type="checkbox" id="dialog-autostart" value="1"/>
							<p>

							<p class="dialog-form-line">
								<label><?php _e('Lecture en boucle', 'vod_infomaniak'); ?></label>
								<input type="checkbox" id="dialog-loop" value="1"/>
							</p>-->

							<?php
								if (!empty($aPlayers)) {
									foreach ($aPlayers as $player) {
										echo "<input type='hidden' id='player_".$player->iPlayer."_width' value='".$player->iWidth."'/>";
										echo "<input type='hidden' id='player_".$player->iPlayer."_height' value='".$player->iHeight."'/>";
										//echo "<input type='hidden' id='player_".$player->iPlayer."_stretch' value='".$player->width."'/>";
										//echo "<input type='hidden' id='player_".$player->iPlayer."_autoload' value='".$player->bAutoPlay."'/>";
										//echo "<input type='hidden' id='player_".$player->iPlayer."_loop' value='".$player->bLoop."'/>";
									}
								}
							?>

							<script>
								(function($) {
									$('#dialog-player').unbind();
									$('#dialog-player').change(function(){
										Vod_setPlayerOptions();
									});

									$('#vod_infomaniak_search_videos').unbind();
									$('#vod_infomaniak_search_videos').keyup(function(){
										$.ajax("<?php echo get_bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php?action=vodsearchvideo",
											{data:{
												q:$('#vod_infomaniak_search_videos').val()
											}
										}).done(function(html){
											$('#vod_infomaniak_videos_container').html(html);
										});
									});

									$('#vod_infomaniak_search_playlists').unbind();
									$('#vod_infomaniak_search_playlists').keyup(function(){
										$.ajax("<?php echo get_bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php?action=vodsearchplaylist",
											{data:{
												q:$('#vod_infomaniak_search_playlists').val()
											}
										}).done(function(html){
											$('#vod_infomaniak_playlists_container').html(html);
										});
									});
								})(jQuery);
							</script>
						</div>
						<div id="dialog-slide-loading" style="text-align:center;display:none;" > Generation du lien de partage 
						<?php
						echo "<img src='" . plugins_url('vod-infomaniak/img/ajax-loader.gif') . "' style='vertical-align:bottom'/> ";
						?>
						</div>

					</div>
				</div>
			</div>
		<?php
		}

		static function buildSyncFolder() {
			?>
				<div id="dialog-sync-fast">
				<?php
				echo "<br/>Synchronisation ... <img src='" . plugins_url('vod-infomaniak/img/ajax-loader.gif') . "' style='vertical-align:bottom'/> ";
				?>
				</div>			
			<?php
			flush();
			ob_flush();
        }

        static function buildFormNoConfig() {
            ?>
            <div id="dialog-vod-logout" style="display:none;" title="<?=__('Probleme de configuration', 'vod_infomaniak')?>">
                <p style="padding: 0px 10px 0px">
                    <?php
                    echo __("Veuillez-vous rendre dans <a href='admin.php?page=configuration'>Videos -> Configuration</a> afin de configurer votre compte.", 'vod_infomaniak');
                    ?>
                </p>
            </div>
        <?php
        }

		static function adminMenu($action_url, $options, $sUrl, $aFolders) {
			?>
			<h2><?php _e('Administration du plugin VOD', 'vod_infomaniak'); ?></h2>

			<form name="adminForm" action="<?php echo $action_url; ?>" method="post">
				<input type="hidden" name="submitted" value="1"/>
                <?php if ($options['vod_api_connected'] == "on") { ?>
                    <input type="hidden" name="logout" value="1"/>
                <?php } ?>

				<p>
					<?php _e("Pour fonctionner, le plugin a besoin de s'interfacer avec votre compte VOD infomaniak.<br/>
				Pour des raisons de securites, il est fortement conseille de creer un nouvel utilisateur dedie dans votre admin infomaniak avec uniquement des droits restreints sur l'API.<br/>
				Pour plus d'information, veuillez vous rendre dans la partie \"Configuration -> Api & Callback\" de votre administration VOD.", 'vod_infomaniak');?>
				</p>
				<p>
					<b>Pour un fonctionnement complet et une intégration plus facile depuis vos articles, le plugin <a href="https://fr.wordpress.org/plugins/classic-editor/">Classic Editor</a> est requis.</b>
				</p>

				<p>
					<label><?php _e('Login', 'vod_infomaniak'); ?>:</label>
					<input type="text" id="vod_api_login" name="vod_api_login"
					       value="<?php echo !empty($options['vod_api_login']) ? $options['vod_api_login']: ""; ?>"/>
				</p>

				<p>
					<label><?php _e('Password', 'vod_infomaniak'); ?>:</label>
					<input type="password" id="vod_api_password" name="vod_api_password"
					       value="<?php echo !empty($options['vod_api_password']) ? "XXXXXX": ""; ?>"/>
				</p>

				<p>
					<label><?php _e("Identifiant de l'espace VOD", 'vod_infomaniak'); ?>:</label>
					<input type="text" id="vod_api_id" name="vod_api_id"
					       value="<?php echo !empty($options['vod_api_id']) ? $options['vod_api_id']: ""; ?>"/>
				</p>
			    <?php wp_nonce_field('update_settings_action', 'plugin_nonce'); ?>
				<p>
					<label><?php _e('Connection', 'vod_infomaniak'); ?>:</label>
					<?php
						if ($options['vod_api_connected'] == "on") {
							echo "<span style='color: green;'>" . __('Connecté', 'vod_infomaniak');
							"</span>";
						} else {
							echo "<span style='color: red;'>" . __('Déconnecté', 'vod_infomaniak');
							"</span>";
						}
						echo " (v".get_option( 'vod_api_version', false ).")";
					?>
				</p>

                <?php if ($options['vod_api_connected'] == "on") { ?>
    				<div class="submit"><input class="button" type="submit" name="Submit"
    				                           value="<?php _e('Deconnexion', 'vod_infomaniak'); ?>"/></div>
                <?php } else { ?>
                    <div class="submit"><input class="button" type="submit" name="Submit"
                                               value="<?php _e('Connexion', 'vod_infomaniak'); ?>"/></div>
                <?php } ?>
			</form>

			<?php
			if ($options['vod_api_connected'] == "on") {
				?>
				<input type="hidden" id="url_ajax_synchro_video" value="<?php echo get_bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php?action=vodsynchrovideo"/>

				<h2><?php _e('Synchronisation des donnees', 'vod_infomaniak'); ?></h2>
				<p><?php _e("Pour fonctionner correctement, cette extension a besoin de se synchroniser regulierement avec votre compte VOD.<br/>Cela vous permet de garder une liste des players, dossiers et playlist a jour sur votre blog.<br/>Cette operation s'effectue automatiquement assez regulierement mais il est egalement possible de forcer une verification ci-dessous.", 'vod_infomaniak'); ?></p>
				<p>
					<label><?php _e('Videos recuperes', 'vod_infomaniak'); ?>:</label>
					<span style="font-weight: bold;" id="iTotalVideo"><?php echo intval($options['vod_count_video']); ?></span>
				</p>
				<p>
					<label><?php _e('Dossiers recuperes', 'vod_infomaniak'); ?>:</label>
					<span style="font-weight: bold;"><?php echo intval($options['vod_count_folder']); ?></span>
				</p>
				<p>
					<label><?php _e('Players recuperes', 'vod_infomaniak'); ?>:</label>
					<span style="font-weight: bold;"><?php echo intval($options['vod_count_player']); ?></span>
				</p>
				<p>
					<label><?php _e('Playlist recuperes', 'vod_infomaniak'); ?>:</label>
					<span style="font-weight: bold;"><?php echo intval($options['vod_count_playlist']); ?></span>
				</p>


				<div class="submit">
					<form id="updateSynchro" name="updateSynchro" action="<?php echo $action_url; ?>" method="post"
					      style="display:inline;">
						<input type="hidden" name="updateSynchro" value="1"/>
						<input class="button" type="submit" name="Submit" id="synchrapidButton"
						       value="<?php _e('Synchroniser dossiers / players / playlists', 'vod_infomaniak'); ?>"/>
					</form>
					<!--<form id="updateSynchroVideo" name="updateSynchroVideo" action="<?php echo $action_url; ?>"
					      method="post" style="display:inline;">
						<input type="hidden" name="updateSynchroVideo" value="1"/>
						<input class="button" type="submit" name="Submit"
						       value="<?php _e('Synchroniser Videos', 'vod_infomaniak'); ?>"/>-->
					</form>
					<input class="button" type="button" name="Submit"
					       value="<?php _e("Synchroniser Videos", 'vod_infomaniak'); ?>"
					       onclick="vodSynchroAjax(0,0);" style="display: inline;"/ id="synchroButton"><div id="importProgress" style="display: inline-block;font-weight:bold;padding: 5px;"></div>
				</div>

				<h2><?php _e("Filtrer l'acces a l'espace VOD", 'vod_infomaniak'); ?></h2>
				<p><?php _e("Par defaut, ce plugin permet d'acceder a l'integralite des videos/dossiers presents sur votre espace VOD.<br/>
				Il peut etre utile dans certains cas de limiter l'acces aux utilisateurs de ce site qu'a une partie des dossiers.<br/>
				L'option ci-dessous permet de restreindre l'acces de ce site a un dossier ainsi que tous ses dossiers fils.", 'vod_infomaniak');?>
					<br/>
				<form id="updateFilterFolder" name="updateFilterFolder" action="<?php echo $action_url; ?>"
				      method="post" style="display:inline;">
					<input type="hidden" name="updateFilterFolder" value="1"/>
					<select id="sFolderPath" name="sFolderPath" style="width:550px;">
						<option value="-1" selected="selected">-- <?php _e("Dossier Racine", 'vod_infomaniak'); ?>--
						</option>
						<?php
							if (empty($aFolders)) {
								echo "<option value='0'>" . __("Aucun dossier disponible", 'vod_infomaniak') . "</option>";
							} else {
								foreach ($aFolders as $oFolder) {
									if (isset($options['vod_filter_folder']) && !empty($options['vod_filter_folder']) && $options['vod_filter_folder'] == $oFolder->sPath) {
										echo "<option value='" . $oFolder->sPath . "' selected='selected'>" . __('Dossier', 'vod_infomaniak') . ": /" . $oFolder->sPath . " , " . __('Nom', 'vod_infomaniak') . ": " . $oFolder->sName . "</option>";
									} else {
										echo "<option value='" . $oFolder->sPath . "'>" . __('Dossier', 'vod_infomaniak') . ": /" . $oFolder->sPath . " , " . __('Nom', 'vod_infomaniak') . ": " . $oFolder->sName . "</option>";
									}
								}
							}
						?>
					</select>
					<input class="button" type="submit" name="Submit" value="<?php _e('Valider', 'vod_infomaniak'); ?>"/>
				</form>
				</p><br/>
				<h2><?php _e("Gestion des droits par groupe d'utilisateur", 'vod_infomaniak'); ?></h2>
				<p>
					<?php _e("Par defaut, toutes les options du plugin sont disponibles pour les utilisateurs a partir du rang de contributeur.<br/>
				Ci-dessous, il est cependant possible de parametrer les options que vous souhaitez proposer a vos utilisateurs.", 'vod_infomaniak');?>
				</p>
				<form id="updateRightPlugins" name="updateRightPlugins" action="<?php echo $action_url; ?>"
				      method="post" style="display:inline;">
					<input type="hidden" name="updateRightPlugins" value="1"/>

					<label for="integration_role"
					       style="width: 180px; display:block; float:left; padding-top: 2px;"><?php _e("Integration", 'vod_infomaniak'); ?></label>
					<select id="integration_role" name="integration_role">
						<option value="contributor"    <?php if ($options['vod_right_integration'] == 1) {
							echo "selected='selected'";
						} ?>><?php _e("Contributeur", 'vod_infomaniak'); ?></option>
						<option value="author"            <?php if ($options['vod_right_integration'] == 2) {
							echo "selected='selected'";
						} ?>><?php _e("Auteur", 'vod_infomaniak'); ?></option>
						<option value="editor"            <?php if ($options['vod_right_integration'] == 3) {
							echo "selected='selected'";
						} ?>><?php _e("Editeur", 'vod_infomaniak'); ?></option>
						<option value="administrator"    <?php if ($options['vod_right_integration'] == 4) {
							echo "selected='selected'";
						} ?>><?php _e("Administrateur", 'vod_infomaniak'); ?></option>
					</select><br/>
					<label for="upload_role"
					       style="width: 180px; display:block; float:left; padding-top: 2px;"><?php _e("Importation de video", 'vod_infomaniak'); ?></label>
					<select id="upload_role" name="upload_role">
						<option value="contributor"    <?php if ($options['vod_right_upload'] == 1) {
							echo "selected='selected'";
						} ?>><?php _e("Contributeur", 'vod_infomaniak'); ?></option>
						<option value="author"            <?php if ($options['vod_right_upload'] == 2) {
							echo "selected='selected'";
						} ?>><?php _e("Auteur", 'vod_infomaniak'); ?></option>
						<option value="editor"            <?php if ($options['vod_right_upload'] == 3) {
							echo "selected='selected'";
						} ?>><?php _e("Editeur", 'vod_infomaniak'); ?></option>
						<option value="administrator"    <?php if ($options['vod_right_upload'] == 4) {
							echo "selected='selected'";
						} ?>><?php _e("Administrateur", 'vod_infomaniak'); ?></option>
					</select><br/>
					<label for="player_role"
					       style="width: 180px; display:block; float:left; padding-top: 2px;"><?php _e("Player video", 'vod_infomaniak'); ?></label>
					<select id="player_role" name="player_role">
						<option value="contributor"    <?php if ($options['vod_right_player'] == 1) {
							echo "selected='selected'";
						} ?>><?php _e("Contributeur", 'vod_infomaniak'); ?></option>
						<option value="author"            <?php if ($options['vod_right_player'] == 2) {
							echo "selected='selected'";
						} ?>><?php _e("Auteur", 'vod_infomaniak'); ?></option>
						<option value="editor"            <?php if ($options['vod_right_player'] == 3) {
							echo "selected='selected'";
						} ?>><?php _e("Editeur", 'vod_infomaniak'); ?></option>
						<option value="administrator"    <?php if ($options['vod_right_player'] == 4) {
							echo "selected='selected'";
						} ?>><?php _e("Administrateur", 'vod_infomaniak'); ?></option>
					</select><br/>
					<label for="playlist_role"
					       style="width: 180px; display:block; float:left; padding-top: 2px;"><?php _e("Playlist", 'vod_infomaniak'); ?></label>
					<select id="playlist_role" name="playlist_role">
						<option value="contributor"    <?php if ($options['vod_right_playlist'] == 1) {
							echo "selected='selected'";
						} ?>><?php _e("Contributeur", 'vod_infomaniak'); ?></option>
						<option value="author"            <?php if ($options['vod_right_playlist'] == 2) {
							echo "selected='selected'";
						} ?>><?php _e("Auteur", 'vod_infomaniak'); ?></option>
						<option value="editor"            <?php if ($options['vod_right_playlist'] == 3) {
							echo "selected='selected'";
						} ?>><?php _e("Editeur", 'vod_infomaniak'); ?></option>
						<option value="administrator"    <?php if ($options['vod_right_playlist'] == 4) {
							echo "selected='selected'";
						} ?>><?php _e("Administrateur", 'vod_infomaniak'); ?></option>
					</select><br/>

					<div class="submit">
						<input class="button" type="submit" name="Submit" value="<?php _e('Valider', 'vod_infomaniak'); ?>"/>
					</div>
				</form>


				<h2><?php _e('Configuration du callback', 'vod_infomaniak'); ?></h2>
				<p>
				<?php 
				if (get_option( 'vod_api_version', false ) == 1) {
					printf(__("Cette option vous permet de mettre a jour automatiquement votre blog a chaque ajout de video a votre espace VOD.<br/>Veuillez aller dans \"<a href='https://statslive.infomaniak.com/vod/configuration.php/g%ds7i%d' target='_blank'>Configuration -> Api & Callback</a>\" et mettre l'adresse suivante dans le champ \"Adresse de Callback\"", 'vod_infomaniak'), $options['vod_api_group'], $options['vod_api_icodeservice']);
				}else{
					printf(__("Cette option vous permet de mettre a jour automatiquement votre blog a chaque ajout de video a votre espace VOD.<br/>Veuillez aller dans \"<a href='https://manager.infomaniak.com/v3/%d/vod/%d/plugin/callbacks' target='_blank'>Extensions CMS/API -> Callback</a>\" et mettre l'adresse suivante dans le champ \"Adresse de Callback\"", 'vod_infomaniak'), $options['vod_api_group'], $options['vod_api_icodeservice']);
				}
				?>
				</p>
				<p>
					<label style="font-weight: bold;"><?php _e('Adresse de callback', 'vod_infomaniak'); ?>:</label>
					<span><?php echo $sUrl . "/?vod_page=callback&key=" . $options['vod_api_callbackKey']; ?></span>
				</p>
				<script>
					document.getElementById('dialog-sync-fast').style.display = 'none';
    			</script>
			<?php
			}
		}

		static function tabLastUpload($aLastImport) {
			$sTab = "";
			if (!empty($aLastImport)) {
				$sTab .= "<span id='tabImportRefresh' style='float:right; padding-right: 20px;'></span>";
				$sTab .= "<h2>" . __('Precedents Envois', 'vod_infomaniak') . "</h2>";
				$sTab .= "<table class='widefat' style='width: 99%'><thead><tr>";
				$sTab .= "<th>" . __('Fichier', 'vod_infomaniak') . "</th><th>" . __('Date', 'vod_infomaniak') . "</th><th>" . __('Statut', 'vod_infomaniak') . "</th><th>" . __('Description', 'vod_infomaniak') . "</th>";
				$sTab .= "</tr></thead><tbody>";
				foreach ($aLastImport as $oImport) {
					$sTab .= "<tr>";
					$sTab .= " <td><img src='" . plugins_url('vod-infomaniak/img/videofile.png') . "' style='vertical-align:bottom'/>" . $oImport['sFileName'] . "</td>";
					$sTab .= " <td>" . $oImport['dDateCreation'] . " UTC+0</td>";
					$sTab .= " <td>";
					if ($oImport['sProcessState'] == "OK") {
						$sTab .= " <img src='" . plugins_url('vod-infomaniak/img/ico-tick.png') . "' style='vertical-align:bottom'/> " . __('OK', 'vod_infomaniak');
					} else {
						if ($oImport['sProcessState'] == "WARNING") {
							$sTab .= "<img src='" . plugins_url('vod-infomaniak/img/videofile.png') . "' style='vertical-align:bottom'/> " . __('Ok (des alertes sont apparues)', 'vod_infomaniak');
						} else {
							if ($oImport['sProcessState'] == "DOWNLOAD") {
								$sTab .= "<img src='" . plugins_url('vod-infomaniak/img/ico-download.png') . "' style='vertical-align:bottom'/> " . __('Telechargement en cours', 'vod_infomaniak');
							} else {
								if ($oImport['sProcessState'] == 'WAITING' || $oImport['sProcessState'] == 'QUEUE' || $oImport['sProcessState'] == 'PROCESSING') {
									$sTab .= "<img src='" . plugins_url('vod-infomaniak/img/ajax-loader.gif') . "' style='vertical-align:bottom'/> " . __('En cours de conversion', 'vod_infomaniak');
								} else {
									$sTab .= "<img src='" . plugins_url('vod-infomaniak/img/ico-exclamation-yellow.png') . "' style='vertical-align:bottom'/> " . __('Erreurs', 'vod_infomaniak');
								}
							}
						}
					}
					$sTab .= " </td>";
					$sTab .= " <td width='50%'>" . $oImport['sLog'] . "</td>";
					$sTab .= "</tr>";
				}
				$sTab .= "</tbody></table>";
			}
			return $sTab;
		}

		static function uploadMenu($actionurl, $options, $aFolders, $sTab = "") {
			?>	
			<input type="hidden" id="version" value="<?php echo get_option( 'vod_api_version', false ) ?>"/>

			<link rel='stylesheet' href='<?php echo plugins_url('vod-infomaniak/css/style.css?1'); ?>' media='all' />

			<h2><?php _e("Envoi d'une nouvelle video", 'vod_infomaniak'); ?></h2>
			<p><?php _e("Ce plug-in vous permet d'ajouter de nouvelles videos directement depuis ce blog. Pour cela, vous n'avez qu'a choisir un dossier puis suivre les instructions", 'vod_infomaniak'); ?>
				:</p>
			<?php if (get_option( 'vod_api_version', false ) == 1) {?>
				<label><b>Fonctionnalite bridee sur cette version, merci de demander au support la migration de votre compte vers la VOD v2</b></label><br/>
			<?php }else{ ?>
			<p>
				<label><b>1.</b> <?php _e("Choix du dossier d'envoi", 'vod_infomaniak'); ?>:</label><br/>
				<select id="uploadSelectFolder" onchange="changeFolderUp1();" onkeyup="changeFolderUp1();">
					<option value="-1" selected="selected">-- Dossier d'envoi --</option>
					<?php
						if (empty($aFolders)) {
							echo "<option value='0'>" . __("Aucun dossier disponible", 'vod_infomaniak') . "</option>";
						} else {
							foreach ($aFolders as $oFolder) {
								echo "<option value='" . $oFolder->iFolder . "'>" . __('Dossier', 'vod_infomaniak') . ": /" . $oFolder->sPath . " , " . __('Nom', 'vod_infomaniak') . ": " . $oFolder->sName . "</option>";
							}
						}
					?>
				</select>
			</p>
			<p>
			<div id="submitLine" class="submit">
				<label><b>2.</b> <?php _e("Choix du type d'envoi", 'vod_infomaniak'); ?>:</label><br/>
				<input class="button" type="button" name="Submit"
				       value="<?php _e("Envoyer depuis cet ordinateur", 'vod_infomaniak'); ?>"
				       onclick="Vod_importVideo();"/>
				<input class="button" type="button" name="Submit"
				       value="<?php _e("Importer depuis un autre site", 'vod_infomaniak'); ?>"
				       onclick="vod_importPopup();"/>
			</div>
			</p>

			<input type="hidden" id="url_ajax_import_video" value="<?php echo get_bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php?action=vodimportvideo"/>

			<div id="vodUploadVideo" style="display:none;">
				<br/>
				<h4 style="margin:0"><?php _e("3. Envoi d'un fichier", 'vod_infomaniak'); ?>:</h4>

				<div id="vodUploadLoader">
					<?php
					echo "Chargement... <img src='" . plugins_url('vod-infomaniak/img/ajax-loader.gif') . "' style='vertical-align:bottom'/> ";
					?>										
				</div>
				<div id="vod-up">
				</div>
			</div>
			<div id="vodImportVideoByUrl" style="display:none;">
				<br/>
				<h4 style="margin:0"><?php _e("3. Import d'un fichier par URL", 'vod_infomaniak'); ?>:</h4>
				<p>
					<input type="text" onkeyup="checkURL();" showsuccess="false" style="width: 500px" value="" name="sUrl" id="sUrl">
				</p>
				<!--<p>
					<input type="checkbox" value="1" onclick="checkAuth();" name="bNeedAuth" id="bNeedAuth">
					<?php _e("Cette adresse necessite une authentification.", 'vod_infomaniak'); ?>
				</p>
				<p id="authLine">
					<label style="font-weight: bold"><?php _e("Login", 'vod_infomaniak'); ?>:</label> <input
						type="text" name="sLogin">
					<label style="font-weight: bold"><?php _e("Password", 'vod_infomaniak'); ?>:</label> <input
						type="password" name="sPassword">
				</p>-->				
				<div class="submit" id="vodImportButton"><input class="button" type="submit" name="Submit" value="<?php _e("Importer", 'vod_infomaniak'); ?>" onclick="downloadFromURL();return false;"/></div>
				<div id="vodImportLoader" style="display:none;">
					<br/>
					<?php
					echo "Telechargement depuis le site origine... <img src='" . plugins_url('vod-infomaniak/img/ajax-loader.gif') . "' style='vertical-align:bottom'/> ";
					?><span id="downloadProgress"/>
				</div>
				<div id="vod-up">
				</div>
			</div>

			<div id="vodEncodeVideo" style="display:none;">
				<br/>
				<h4 style="margin:0"><?php _e("4. Traitement du fichier", 'vod_infomaniak'); ?>:</h4>

				<div id="vodEncodeLoader">
					<ul>
						<li id="VodEncodeS1" class="vodencode"><?php _e('Fichier recu', 'vod_infomaniak'); ?></li>
						<li id="VodEncodeS2" class="vodencode"><span id="encodeStep"/>Pre-encodage</span>  <?php echo "<img id='encodeVodLoader' src='" . plugins_url('vod-infomaniak/img/ajax-loader.gif') . "' style='vertical-align:bottom;display:none'/> ";?> <span id="encodeProgress"/></li> 
						<li id="VodEncodeS3" class="vodencode">Au moins un des encodages est disponible *</li>
					</ul>
					<span id="notaDispo" class="vodencode"> * Vous pouvez d'or et déjà intégrer votre vidéo, l'ensemble des encodages sera automatiquement visible une fois disponible</span>

				</div>
			</div>
			
			
			<div id="tabImport"><?php echo $sTab; ?></div>

			<div id="dialog-message-upload" title="<?php _e('Envoi termine'); ?>" style="display:none;">
				<p style="padding-left: 10px;">
					<?php _e("L'ajout de cette video a correctement ete pris en compte.<br/>Vous pouvez retrouver l'avancement de cette conversion video dans le tableau ci-dessous."); ?>
				</p>
			</div>
		<?php
			}
		}

		static function uploadPopup($token, $oFolder, $bResult = false) {
			?>
			<script type="text/javascript" charset="iso-8859-1"
			        src="<?php echo plugins_url('vod-infomaniak/js/swfobject.js'); ?>"></script>
			<!--<script type="text/javascript" charset="iso-8859-1"
			        src="//vod.infomaniak.com/apiUpload/flashUpload.js"></script>-->

			<h2><?php _e("Utilitaire d'envoi de video", 'vod_infomaniak'); ?></h2>
			<p>
				<label style="font-weight: bold"><?php _e("Dossier d'envoi", 'vod_infomaniak'); ?>:</label>
				<span><img src="<?php echo plugins_url('vod-infomaniak/img/ico-folder-open-16x16.png'); ?>"
				           style="vertical-align:bottom"/> <?php echo $oFolder->sName; ?>
					( '<?php echo $oFolder->sPath; ?>' )</span>
			</p>
			<p>
				<label style="font-weight: bold"><?php _e("Limites", 'vod_infomaniak'); ?>:</label>
			<ul style="list-style: disc inside; margin-left: 20px;">
				<li><?php _e("Le poids des fichiers envoyes via ce module est limite a 1Go", 'vod_infomaniak'); ?></li>
				<li><?php _e("Les formats videos supportes sont avi, flv, mov, mpeg, mp4, mkv, rm, wmv, m4v, vob, 3gp, webm, f4v, ts", 'vod_infomaniak'); ?></li>
				<li><?php _e("L'envoi doit etre effectue en moins de 4 heures", 'vod_infomaniak'); ?></li>
			</ul>
			</p>
			<p><label style="font-weight: bold"><?php _e("Envoi", 'vod_infomaniak'); ?>:</label></p>
			<div id="up"></div>


		<?php
		}

		static function importPopup($action_url, $oFolder, $bResult = false) {
			?>
			<h2><?php _e("Utilitaire d'importation de video", 'vod_infomaniak'); ?></h2>

			<form name="adminForm" action="<?php echo $action_url; ?>" method="post">
				<input type="hidden" name="submit" value="1"/>
				<input type="hidden" name="sAction" value="popupImport"/>
				<input type="hidden" name="iFolder" value="<?php echo $oFolder->iFolder; ?>"/>

				<p>
					<label style="font-weight: bold"><?php _e("Dossier d'envoi", 'vod_infomaniak'); ?>:</label>
					<span><img src="<?php echo plugins_url('vod-infomaniak/img/ico-folder-open-16x16.png'); ?>"
					           style="vertical-align:bottom"/> <?php echo $oFolder->sName; ?>
						( '<?php echo $oFolder->sPath; ?>' )</span>
				</p>

				<p>
					<label style="font-weight: bold"><?php _e("Limites", 'vod_infomaniak'); ?>:</label>
				<ul style="list-style: disc inside; margin-left: 20px;">
					<li><?php _e("Le poids des fichiers envoyes via ce module est limite a 1Go", 'vod_infomaniak'); ?></li>
					<li><?php _e("Les formats videos supportes sont avi, flv, mov, mpeg, mp4, mkv, rm, wmv, m4v, vob, 3gp, webm, f4v, ts", 'vod_infomaniak'); ?></li>
				</ul>
				</p>
				<p>
					<label style="font-weight: bold"><?php _e("Adresse", 'vod_infomaniak'); ?>:</label>
					<select name="sProtocole" id="sProtocole">
						<option value="http">http://</option>
						<option value="https">https://</option>
						<option value="ftp">ftp://</option>
					</select>
					<input type="text" onkeyup="checkURL();" showsuccess="false" style="width: 50%" value="" name="sUrl"
					       id="sUrl">
				</p>
				<p>
					<input type="checkbox" value="1" onclick="checkAuth();" name="bNeedAuth" id="bNeedAuth">
					<?php _e("Cette adresse necessite une authentification.", 'vod_infomaniak'); ?>
				</p>

				<p id="authLine">
					<label style="font-weight: bold"><?php _e("Login", 'vod_infomaniak'); ?>:</label> <input
						type="text" name="sLogin">
					<label style="font-weight: bold"><?php _e("Password", 'vod_infomaniak'); ?>:</label> <input
						type="password" name="sPassword">
				</p>

				<div class="submit"><input class="button" type="submit" name="Submit"
				                           value="<?php _e("Importer", 'vod_infomaniak'); ?>"/></div>
			</form>
			<script type="text/javascript">
				jQuery('#adminmenuwrap').remove();

				checkURL = function () {
					var url = jQuery('#sUrl').val();
					if (url.indexOf("http://") != -1) {
						jQuery('#sProtocole').val('http');
						jQuery('#sUrl').val(url.replace(/http:\/\//i, ""));
					} else if (url.indexOf("https://") != -1) {
						jQuery('#sProtocole').val('https');
						jQuery('#sUrl').val(url.replace(/https:\/\//i, ""));
					} else if (url.indexOf("ftp://") != -1) {
						jQuery('#sProtocole').val('ftp');
						jQuery('#sUrl').val(url.replace(/ftp:\/\//i, ""));
					}
				};

				checkAuth = function () {
					if (jQuery("#bNeedAuth").attr('checked')) {
						jQuery("#authLine").show();
					} else {
						jQuery("#authLine").hide();
					}
				};
				checkAuth();

				CallParentWindowFunction = function () {
					window.opener.uploadFinish();
					return false;
				}
				<?php if($bResult){ echo "CallParentWindowFunction();"; } ?>
			</script>
		<?php
		}

		static function managementMenu($action_url, $sPagination, $aOptions, $aVideos) {
			//var_dump ($aVideos);
			?>

			<h2><?php _e("Gestionnaire de videos", 'vod_infomaniak'); ?></h2>
			<!--<input type="text" id="vod_api_version" value="<?php echo get_option( 'vod_api_version', false ) ?>"/>-->

			<div class="tablenav" style="padding-right: 20px;">
				<div class='tablenav-pages'>
					<?php echo $sPagination; ?>
				</div>
			</div>

			<div id="dialog-confirm-vod" title="<?php _e("Supprimer une video", 'vod_infomaniak'); ?>"
			     style="display:none;">
				<form id="adminFormVodDelete" name="adminForm" action="<?php echo $action_url; ?>" method="POST">
					<input type="hidden" name="submitted" value="1"/>
					<input type="hidden" name="sAction" value="delete"/>
					<input type="hidden" id="dialog-confirm-id" name="dialog-confirm-id" value=""/>

					<p style="padding-left: 10px;">
						<?php _e("Vous etes sur le point de supprimer la video", 'vod_infomaniak'); ?> '<span
							id="dialog-confirm-title" style="font-weight: bold;"></span>'.<br/><br/>
					<span style="color: darkRed; font-style:italic;">
						<span style="font-weight: bold;"><?php _e("Attention", 'vod_infomaniak'); ?>:</span>
						<?php _e("C'est une suppression definitive de la video, il n'y pas de corbeille ou de moyen de la recuperer une fois effacer.", 'vod_infomaniak'); ?>
					</span><br/><br/>
						<?php _e("Etes-vous sur de vouloir continuer ?", 'vod_infomaniak'); ?>
					</p>
				</form>
			</div>

			<div id="dialog-modal-vod" title="<?php _e("Previsualisation d'une video", 'vod_infomaniak'); ?>" style="display:none; padding: 5px; overflow: hidden;">
				<h3 id="dialog-modal-title" style="text-align:center; margin: 5px">Titre</h3>
				<center>
					<iframe id="dialog-modal-video" frameborder="0" width="560" height="315" src="#"></iframe>
				</center>
				<div style="padding-left:5px">
					<h3><?php _e("Informations", 'vod_infomaniak'); ?></h3>

					<p>

					<form name="adminForm" action="<?php echo $action_url; ?>" method="POST">
						<input type="hidden" name="submitted" value="1"/>
						<input type="hidden" name="sAction" value="rename"/>
						<input type="hidden" id="dialog-modal-id" name="dialog-modal-id" value=""/>
						<input class="button" type="submit" value="Modifier" style="float:right; margin-right:25px;"/>
						<input id="dialog-modal-name" name="dialog-modal-name" text=""
						       style="float:right; width: 350px; border: 1px solid #CCCCCC; color: #444444; border-radius: 3px; padding: 4px"/>
					</form>
					<label><?php _e("Nom", 'vod_infomaniak'); ?>:</label>
					</p>
					<p id="dialog-modal-access-block" style="padding-top: 2px;">
						<label><?php _e("Restriction d'acces", 'vod_infomaniak'); ?>:</label>
						<span id="dialog-modal-access" style="font-weight: bold; padding-left: 45px;"></span>
					</p>

					<h3><?php _e("Integration", 'vod_infomaniak'); ?></h3>

					<p>
						<a id="dialog-modal-url-href" href="#" target="_blank">
							<img src="<?php echo plugins_url('vod-infomaniak/img/ico-redo.png'); ?>"
							     style="float:right; margin-right:25px; vertical-align:bottom;"
							     alt="<?php _e("Visualiser la video", 'vod_infomaniak'); ?>"/>
						</a>
						<input id="dialog-modal-url" text=""
						       style="float:right; width: 393px; margin-right: 5px; border 1px solid #CCC; border-radius: 3px; background-color: #FFF; margin-top:0; padding: 4px; border: 1px solid #CCCCCC; color: #444444;"
						       readonly="value" onfocus="this.select();"/>
						<label><?php _e("Url de la video", 'vod_infomaniak'); ?>:</label>
					</p>

					<p>
						<a id="dialog-modal-url-img-href" href="#" target="_blank">
							<img src="<?php echo plugins_url('vod-infomaniak/img/ico-redo.png'); ?>"
							     style="float:right; margin-right:25px; vertical-align:bottom;"
							     alt="Visualiser l'image"/>
						</a>
						<input id="dialog-modal-url-img" text=""
						       style="float:right; width: 393px; margin-right: 5px; border 1px solid #CCC; border-radius: 3px; background-color: #FFF; margin-top:0; padding: 4px; border: 1px solid #CCCCCC; color: #444444;"
						       readonly="value" onfocus="this.select();"/>
						<label><?php _e("Url de l'image", 'vod_infomaniak'); ?>:</label>
					</p>

					<p>
						<input id="dialog-modal-balise" text=""
						       style="float:right; margin-right:25px; width: 414px; border 1px solid #CCC; border-radius: 3px; background-color: #FFF; margin-top:0; padding: 4px; border: 1px solid #CCCCCC; color: #444444;"
						       readonly="value" onfocus="this.select();"/>
						<label><?php _e("Code d'integration", 'vod_infomaniak'); ?>:</label>
					</p>
				</div>
				<!--<div style="text-align:center;padding-top:15px;">
					<ul style="display:inline;">
						<li style="display:inline">
							<a id="dialog-modal-admin" href="#" target="_blank"
							   style="text-decoration: none; color:#444444; font-weight: bold;">
								<img src="<?php echo plugins_url('vod-infomaniak/img/ico-video.png'); ?>"
								     alt="<?php _e("Administrer cette video", 'vod_infomaniak'); ?>"
								     style="vertical-align:bottom"/> <?php _e("Administrer cette video", 'vod_infomaniak'); ?>
							</a>
						</li>
						<li style="display:inline; padding-left: 20px">
							<a id="dialog-modal-admin2" href="#" target="_blank"
							   style="text-decoration: none; color:#444444; font-weight: bold;">
								<img src="<?php echo plugins_url('vod-infomaniak/img/ico-statistics.png'); ?>"
								     alt="<?php _e("Voir les statistiques de cette video", 'vod_infomaniak'); ?>"
								     style="vertical-align:bottom"/> <?php _e("Voir les statistiques", 'vod_infomaniak'); ?>
							</a>
						</li>
						<li style="display:inline; padding-left: 20px">
							<form id="adminFormPost" name="adminFormPost" action="<?php echo $action_url; ?>"
							      method="POST" style="display:none">
								<input type="hidden" name="submitted" value="1"/>
								<input type="hidden" name="sAction" value="post"/>
								<input type="hidden" id="dialog-post-id" name="dialog-post-id" value=""/>
							</form>
							<a id="dialog-modal-admin3" href="javascript:;" onclick="jQuery('#adminFormPost').submit();"
							   style="text-decoration: none; color:#444444; font-weight: bold;">
								<img src="<?php echo plugins_url('vod-infomaniak/img/ico-edit.png'); ?>"
								     alt="<?php _e("Creer un article", 'vod_infomaniak'); ?>"
								     style="vertical-align:bottom"/> <?php _e("Creer un article", 'vod_infomaniak'); ?>
							</a>
						</li>
					</ul>
				</div>-->
			</div>

			<table class="widefat" style="width: 99%">
				<thead>
				<tr>
					<th width="50%"><?php _e("Video", 'vod_infomaniak'); ?></th>
					<th><?php _e("Dossier", 'vod_infomaniak'); ?></th>
					<th><?php _e("Date d'upload", 'vod_infomaniak'); ?></th>
					<th width="80"><?php _e("Action", 'vod_infomaniak'); ?></th>
				</tr>
				</thead>
				<tbody>
				<?php
					if (empty($aVideos)) {
						echo "<option value='0'>" . __("Aucune video disponible", 'vod_infomaniak') . "</option>";
					} else {
						foreach ($aVideos as $oVideo) {
							?>
							<tr>
								<td>
									<?php if ($oVideo->sExtension == "M4A" || $oVideo->sExtension == "MP3") { ?>
										<img src="<?php echo plugins_url('vod-infomaniak/img/audiofile.png'); ?>"
										     style="vertical-align:bottom"/>
									<?php } else { ?>
										<img src="<?php echo plugins_url('vod-infomaniak/img/videofile.png'); ?>"
										     style="vertical-align:bottom"/>
									<?php } ?>
									<a href="javascript:; return false;"
									   onclick="openVodPopup('<?php echo $oVideo->iVideo; ?>', '<?php echo addslashes(htmlspecialchars($oVideo->sName)); ?>','<?php echo $oVideo->sPath . $oVideo->sServerCode; ?>', '<?php echo strtolower($oVideo->sExtension); ?>', '<?php echo strtolower($oVideo->sAccess); ?>', '<?php echo $oVideo->sToken; ?>', '<?php echo $oVideo->iFolder; ?>', '<?php echo $oVideo->sImageUrlV2; ?>', '<?php echo $oVideo->sVideoUrlV2; ?>', '<?php echo $oVideo->sShareUrlV2; ?>','<?php echo $oVideo->sServerCode; ?>'); return false;"><?php echo ucfirst(stripslashes($oVideo->sName)); ?></a>
								</td>
								<td><img
										src="<?php echo plugins_url('vod-infomaniak/img/ico-folder-open-16x16.png'); ?>"
										style="vertical-align:bottom"/> <?php echo $oVideo->sPath; ?></td>
								<td><?php echo $oVideo->dUpload; ?></td>
								<td>
									<a href="javascript:; return false;"
									   onclick="openVodPopup('<?php echo $oVideo->iVideo; ?>', '<?php echo addslashes(htmlspecialchars($oVideo->sName)); ?>','<?php echo $oVideo->sPath . $oVideo->sServerCode . "', '" . strtolower($oVideo->sExtension); ?>', '<?php echo strtolower($oVideo->sAccess); ?>', '<?php echo $oVideo->sToken; ?>', '<?php echo $oVideo->iFolder; ?>', '<?php echo $oVideo->sImageUrlV2; ?>', '<?php echo $oVideo->sVideoUrlV2; ?>', '<?php echo $oVideo->sShareUrlV2; ?>','<?php echo  $oVideo->sServerCode; ?>'); return false;"><img
											src="<?php echo plugins_url('vod-infomaniak/img/ico-information.png'); ?>"
											alt="<?php _e("Information sur cette video", 'vod_infomaniak'); ?>"/></a>

									<?php if (get_option( 'vod_api_version', false ) == 1) {?>
									<a href="https://statslive.infomaniak.com/vod/videoDetail.php/g<?php echo $aOptions['vod_api_group']; ?>s7i<?php echo $aOptions['vod_api_icodeservice']; ?>?iFileCode=<?php echo $oVideo->iVideo; ?>"
									   target="_blank"><img
											src="<?php echo plugins_url('vod-infomaniak/img/ico-video.png'); ?>"
											alt="<?php _e("Administrer cette video", 'vod_infomaniak'); ?>"/></a>
									<a href="https://statslive.infomaniak.com/vod/videoDetail.php/g<?php echo $aOptions['vod_api_group']; ?>s7i<?php echo $aOptions['vod_api_icodeservice']; ?>?iFileCode=<?php echo $oVideo->iVideo; ?>&tab=2"
									   target="_blank">
								    <img
										src="<?php echo plugins_url('vod-infomaniak/img/ico-statistics.png'); ?>"
										alt="<?php _e("Voir les statistiques de cette video", 'vod_infomaniak'); ?>"/></a>
									<?php }else{ ?>



									<a href="https://manager.infomaniak.com/v3/<?php echo $aOptions['vod_api_group']; ?>/vod/<?php echo $aOptions['vod_api_icodeservice']; ?>/browse/<?php echo $oVideo->sFolderCode; ?>/<?php echo $oVideo->sServerCode; ?>"
									   target="_blank"><img
											src="<?php echo plugins_url('vod-infomaniak/img/ico-video.png'); ?>"
											alt="<?php _e("Administrer cette video", 'vod_infomaniak'); ?>"/></a>
									
									<?php }?>	
									
									<a href="javascript:; return false;"
									   onclick="confirmVodDelete('<?php echo $oVideo->iVideo; ?>', '<?php echo addslashes(htmlspecialchars($oVideo->sName)); ?>');"><img
											src="<?php echo plugins_url('vod-infomaniak/img/ico-delete.png'); ?>"
											alt="<?php _e("Supprimer cette video", 'vod_infomaniak'); ?>"/></a>
								</td>
							</tr>
						<?php
						}
					}
				?>
				</tbody>
				<script>
					confirmVodDelete = function (iVideo, sTitle) {
						jQuery("#dialog-confirm-id").val(iVideo);
						jQuery("#dialog-confirm-title").text(sTitle);
						jQuery("#dialog-confirm-vod").dialog({
							resizable: false,
							width: 600,
							height: 210,
							modal: true,
							buttons: {
								"<?php _e("Supprimer definitivement la video",'vod_infomaniak'); ?>": function () {
									jQuery('#adminFormVodDelete').submit();
								},
								"<?php _e("Annuler",'vod_infomaniak'); ?>": function () {
									jQuery(this).dialog("close");
								}
							}
						});
					}
					openVodPopup = function (iVideo, title, url, sExtension, sAccess, sToken, iFolder, sImageUrlV2, sVideoUrlV2, sShareUrlV2, sServerCode) {
						var urlComplete = "<?php echo $aOptions['vod_api_id'];?>" + url;
						var sParam = "";
						if (sToken != "") {
							//sParam = "?sKey=" + sToken + "&ees";
							sBalise = "vod tokenfolder='" + iFolder + "'";
						} else {
							sBalise = 'vod';
						}
						jQuery("#dialog-modal-id").val(iVideo);
						jQuery("#dialog-post-id").val(iVideo);
						jQuery("#dialog-modal-title").text(title);
						jQuery("#dialog-modal-name").val(title);
//						jQuery("#dialog-modal-url").val("https://vod.infomaniak.com/redirect/" + urlComplete + "." + sExtension);
//						jQuery("#dialog-modal-url-href").attr("href", "https://vod.infomaniak.com/redirect/" + urlComplete + "." + sExtension + sParam);
						jQuery("#dialog-modal-url").val(sVideoUrlV2);
						jQuery("#dialog-modal-url-href").attr("href", sVideoUrlV2 + sParam);
//						jQuery("#dialog-modal-url-img").val("https://vod.infomaniak.com/redirect/" + urlComplete + ".jpg");
//						jQuery("#dialog-modal-url-img-href").attr("href", "https://vod.infomaniak.com/redirect/" + urlComplete + ".jpg");
						jQuery("#dialog-modal-url-img").val(sImageUrlV2);
						jQuery("#dialog-modal-url-img-href").attr("href", sImageUrlV2);

						if (<?php echo get_option( 'vod_api_version', false ) ?> == 1){
							jQuery("#dialog-modal-balise").val("[" + sBalise + "]" + url + "." + sExtension + "[/vod]");
						}else{						//v2
							//if (sToken != "") {
							//	sBalise = "vod v2 tokenfolder='" + iFolder + "'";	//plus utils, la detection du token est automantique si presente
							//} else {
								sBalise = "vod version='2'";
							//}
							jQuery("#dialog-modal-balise").val("[" + sBalise + "]" + sServerCode +"[/vod]");
						}	
						jQuery("#dialog-modal-admin").attr("href", "https://statslive.infomaniak.com/vod/videoDetail.php/g<?php echo $aOptions['vod_api_group'];?>s7i<?php echo $aOptions['vod_api_icodeservice'];?>?iFileCode=" + iVideo);
						jQuery("#dialog-modal-admin2").attr("href", "https://statslive.infomaniak.com/vod/videoDetail.php/g<?php echo $aOptions['vod_api_group'];?>s7i<?php echo $aOptions['vod_api_icodeservice'];?>?iFileCode=" + iVideo + "&tab=2");

						if (<?php echo get_option( 'vod_api_version', false ) ?> == 2){
							jQuery("#dialog-modal-video").attr("src", sShareUrlV2 + sParam);
						}else{
							jQuery("#dialog-modal-video").attr("src", "https://vod.infomaniak.com/iframe.php?url=" + urlComplete + "." + sExtension + sParam + "&player=576&vod=214&preloadImage=" + urlComplete + ".jpg");
						}

						textAccess = "";
						if (sAccess != '' && sAccess != 'all') {
							textAccess += "<?php _e("Video Geolocalise",'vod_infomaniak'); ?>";
						}
						if (sToken != "") {
							if (textAccess != "") textAccess += ", ";
							textAccess += "<?php _e("Securise avec un token",'vod_infomaniak'); ?>";
						}
						if (textAccess != "") {
							jQuery("#dialog-modal-access").text(textAccess);
							jQuery("#dialog-modal-access-block").show();
						} else {
							jQuery("#dialog-modal-access-block").hide();
						}

						jQuery("#dialog-modal-vod").dialog({
							width: 620,
							height: 675,
							resizable: false,
							closeText: "",
							beforeClose: function (event, ui) {
								jQuery("#dialog-modal-video").attr("src", "#");
							}
						});
						return false;
					}
				</script>
			</table>

			<div class="tablenav" style="padding-right: 20px;">
				<div class='tablenav-pages'>
					<?php echo $sPagination; ?>
				</div>
			</div>
		<?php
		}

		static function playlistMenu($actionurl, $aOptions, $aPlaylist) {
			?>
			<h2><?php _e("Playlists", 'vod_infomaniak'); ?></h2>
			<p>
				<?php if (get_option( 'vod_api_version', false ) == 1) {
				printf(__("Si vous desirez ajouter ou modifier les playlist ci-dessous, veuillez vous rendre dans <a href='https://statslive.infomaniak.com/vod/playlists.php/g%ds7i%d' target='_blank'>la console d'administration</a>", 'vod_infomaniak'), $aOptions['vod_api_group'], $aOptions['vod_api_icodeservice']);
				}else{
				echo ("Si vous desirez ajouter ou modifier les playlist ci-dessous, veuillez vous rendre dans <a href='https://manager.infomaniak.com/' target='_blank'>la console d'administration</a>"); 
				}
				?>
			</p>
			<h2><?php _e("Precedents Envois", 'vod_infomaniak'); ?></h2>
			<table class='widefat' style='width: 99%'>
				<thead>
				<tr>
					<th width="20%"><?php _e("Nom", 'vod_infomaniak'); ?></th>
					<th width="30%"><?php _e("Description", 'vod_infomaniak'); ?></th>
					<th><?php _e("Nombre videos", 'vod_infomaniak'); ?></th>
					<th><?php _e("Duree", 'vod_infomaniak'); ?></th>
					<th><?php _e("Mode de lecture", 'vod_infomaniak'); ?></th>
					<th><?php _e("Date", 'vod_infomaniak'); ?></th>
					<th width="80px"><?php _e("Action", 'vod_infomaniak'); ?></th>
				</tr>
				</thead>
				<tbody>
				<?php
					if (empty($aPlaylist)) {
						echo "<h3>" . __("Aucune playlist disponible", 'vod_infomaniak') . "</h3>";
					} else {
						foreach ($aPlaylist as $oPlaylist) {
                            ?>
							<tr>
								<td><img src="<?php echo plugins_url('vod-infomaniak/img/ico-display-list.png'); ?>"
								         style="vertical-align:bottom; padding: 0px 5px;"/> <?php echo ucfirst($oPlaylist->sPlaylistName); ?>
								</td>
								<td><?php echo !empty($oPlaylist->sPlaylistDescription) ? ucfirst($oPlaylist->sPlaylistDescription): "&nbsp;"; ?> </td>
								<td><?php echo $oPlaylist->iTotal; ?></td>
								<?php
									$duration = intval($oPlaylist->iTotalDuration / 100);
									$hour = intval($duration / 3600);
									$min = intval($duration / 60) % 60;
									$sec = intval($duration) % 60;

									$str = "";
									$str .= $hour > 0 ? $hour . "h. " : '';
									$str .= $min > 0 ? $min . "m. " : '';
									$str .= $sec > 0 ? $sec . "s." : '';
								?>
								<td><?php echo !empty($str) ? $str : "&nbsp;"; ?> </td>
								<td><?php echo $oPlaylist->sMode; ?></td>
								<td><?php echo $oPlaylist->dCreated; ?></td>
								<td>
									<?php if (get_option( 'vod_api_version', false ) == 1) {	//todo, recup le code playlist en v2 pour mettre bon lien ?>
									<a href="https://statslive.infomaniak.com/vod/playlists.php/g<?php echo $aOptions['vod_api_group']; ?>s7i<?php echo $aOptions['vod_api_icodeservice']; ?>?sAction=showPlaylist&iPlaylistCode=<?php echo $oPlaylist->iPlaylistCode; ?>"
									   target="_blank"><img
											src="<?php echo plugins_url('vod-infomaniak/img/ico-information.png'); ?>"
											alt="<?php _e("Administrer cette playlist", 'vod_infomaniak'); ?>"/></a>
									<?php } ?>
                                    <a href="<?=$actionurl?>&create=<?=$oPlaylist->iPlaylistCode;?>" title="<?php _e("Creer un article", 'vod_infomaniak'); ?>">
                                        <img src="<?php echo plugins_url('vod-infomaniak/img/ico-edit.png'); ?>"
                                             alt="<?php _e("Creer un article", 'vod_infomaniak'); ?>"/>
                                    </a>
								</td>
							</tr>
						<?php
						}
					}
				?>
				</tbody>
			</table>
		<?php
		}

		static function implementationMenu($sActionUrl, $aOptions, $aPlayers) {
			?>

			<h2><?php _e("Creation ou modification de players", 'vod_infomaniak'); ?></h2>
			<p><?php printf(__("Afin de modifier ou creer de nouveaux players, nous vous invitons a vous rendre dans votre administration vod", 'vod_infomaniak'), $aOptions['vod_api_group'], $aOptions['vod_api_icodeservice']); ?></p>
		<?php
		}

		static function buildPagination($iCurrentPage, $iLimit, $iTotal) {
			$iTotalPage = $iTotal;
			$iPageTotal = floor(($iTotal - 1) / $iLimit) + 1;
			$page_list = "";

			if (($iCurrentPage != 1) && ($iCurrentPage)) {
				$page_list .= "  <a href=\" " . $_SERVER['PHP_SELF'] . "?page=vod-infomaniak/vod.class.php&p=1\" title=\"First Page\">«</a> ";
			}

			if (($iCurrentPage - 1) > 0) {
				$page_list .= "<a href=\" " . $_SERVER['PHP_SELF'] . "?page=vod-infomaniak/vod.class.php&p=" . ($iCurrentPage - 1) . "\" title=\"Previous Page\"><</a> ";
			}

			for ($i = 1; $i <= $iPageTotal; $i++) {
				if ($i <= 2 || $i > $iPageTotal - 2 || ($i >= $iCurrentPage - 2 && $i <= $iCurrentPage + 2)) {
					if ($i == $iCurrentPage) {
						$page_list .= "<b>" . $i . "</b>";
					} else {
						$page_list .= "<a href=\" " . $_SERVER['PHP_SELF'] . "?page=vod-infomaniak/vod.class.php&p=" . $i . "\" title=\"Page " . $i . "\">" . $i . "</a>";
					}
					$page_list .= " ";
				} else {
					if ($i == 3 || $i == $iPageTotal - 2) {
						$page_list .= "... ";
					}
				}
			}

			if (($iCurrentPage + 1) <= $iPageTotal) {
				$page_list .= "<a href=\"" . $_SERVER['PHP_SELF'] . "?page=vod-infomaniak/vod.class.php&p=" . ($iCurrentPage + 1) . "\" title=\"Next Page\">></a> ";
			}

			if (($iCurrentPage != $iPageTotal) && ($iPageTotal != 0)) {
				$page_list .= "<a href=\"" . $_SERVER['PHP_SELF'] . "?page=vod-infomaniak/vod.class.php&p=" . $iPageTotal . "\" title=\"Last Page\">»</a> ";
			}
			$page_list .= "</td>\n";

			return $page_list;
		}
	}

?>