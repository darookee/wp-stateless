<div class="wrap" ng-app="wpStatelessApp">
    <h2>Menu Page Title</h2>
    <div class="description">This is description of the page.</div>
    <?php settings_errors(); ?> 

    <h2 class="nav-tab-wrapper">  
        <a href="#stless_settings_tab" class="stless_setting_tab nav-tab  nav-tab-active">Settings</a>  
        <a href="#stless_sync_tab" class="stless_setting_tab nav-tab">Sync</a>  
        <a href="#stless_supports_tab" class="stless_setting_tab nav-tab">Support</a>  
    </h2>  

    <div class="stless_settings">
        <div id="stless_settings_tab" class="stless_settings_content active" ng-controller="wpStatelessSettings">
            <form method="post" action=""> 
                <input type="hidden" name="action" value="stateless_settings">
                <?php wp_nonce_field('wp-stateless-settings', '_smnonce');?>
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row">General</th>
                            <td>
                                <fieldset>
                                    <legend class="screen-reader-text"><span>General</span></legend>
                                    <h4>Mode: {{sm.mode}}</h4>
                                    <p class="sm-mode">
                                        <label for="sm_mode_disabled"><input id="sm_mode_disabled" type="radio" name="sm[mode]" value="disabled" ng-checked="sm.mode == 'disabled'">Disabled<small class="description">Disable Stateless Media.</small></label>
                                    </p>
                                    <p class="sm-mode">
                                        <label for="sm_mode_backup"><input id="sm_mode_backup" type="radio" name="sm[mode]" value="backup" ng-checked="sm.mode == 'backup'">Backup<small class="description">Push media files to Google Storage but keep using local ones.</small></label>
                                    </p>
                                    <p class="sm-mode">
                                        <label for="sm_mode_cdn"><input id="sm_mode_cdn" type="radio" name="sm[mode]" value="cdn" ng-checked="sm.mode == 'cdn'">CDN<small class="description">Push media files to Google Storage and use them directly from there.</small></label>
                                    </p>
                                    <p class="sm-mode">
                                        <label for="sm_mode_stateless"><input id="sm_mode_stateless" type="radio" name="sm[mode]" value="stateless" ng-checked="sm.mode == 'stateless'">Stateless<small class="description">Uploads and serves your media library items to and from GCS. Your local copy is removed.</small></label>
                                    </p>
                                    <hr>

                                    <h4>File URL Replacement: </h4>
                                    <p class="sm-file-url">
                                        <select name="sm[body_rewrite]" id="sm_file_url" ng-model="sm.body_rewrite">
                                            <option value="true" selected="selected">Enable</option>
                                            <option value="false">Disable</option>
                                        </select>
                                    </p>
                                    <p class="description">Scans post content and meta during presentation and replaces local media file urls with GCS urls. This setting does not modify your database.</p>
                                    <hr>

                                    <h4>Dynamic Image Support: </h4>
                                    <p class="dynamic_img_sprt">
                                        <select name="sm[on_fly]" id="dynamic_img_sprt" ng-model="sm.on_fly">
                                            <option value="true" selected="selected">Enable</option>
                                            <option value="false">Disable</option>
                                        </select>
                                    </p>
                                    <p class="description">Upload image thumbnails generated by your theme and plugins that do not register media objects with the media library.</p>                  
                                </fieldset>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">Google Cloud Storage (GCS)</th>
                            <td>
                                <fieldset>
                                    <legend class="screen-reader-text"><span>Google Cloud Storage (GCS)</span></legend>
                                    <h4>Bucket: </h4>
                                    <p>
                                        <label for="bucket_name">
                                            <input name="sm[bucket]" type="text" id="bucket_name" class="regular-text ltr" ng-model="sm.bucket">
                                        </label>
                                    </p>
                                    <p class="description">The name of the GCS bucket.</p>
                                    <hr>       

                                    <h4>Bucket Folder: </h4>
                                    <p>
                                        <label for="bucket_folder_name">
                                            <input name="sm[root_dir]" type="text" id="bucket_folder_name" class="regular-text ltr" ng-model="sm.root_dir">
                                        </label>
                                    </p>
                                    <p class="description">If you would like files to be uploaded into a particular folder within the bucket, define that path here.</p>
                                    <hr>

                                    <h4>Service Account JSON: </h4>
                                    <p>
                                        <label for="service_account_json">
                                            <textarea name="sm[key_json]" type="text" id="service_account_json" class="regular-text ltr" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">{{sm.key_json}}</textarea>
                                        </label>
                                    </p>
                                    <p class="description">Private key in JSON format for the service account WP-Stateless will use to connect to your Google Cloud project and bucket.</p>
                                    <hr>

                                    <h4>Cache-Control: </h4>
                                    <p>
                                        <select name="sm[override_cache_control]" id="gcs_cache_control" ng-model="sm.override_cache_control">
                                            <option value="true">Enable</option>
                                            <option value="false" selected="selected">Disable</option>
                                        </select>
                                    </p>

                                    <p ng-show="sm.override_cache_control == 'true'">
                                        <label for="gcs_cache_control_text">
                                            <input name="sm[cache_control]" type="text" id="gcs_cache_control_text" class="regular-text ltr" placeholder="public, max-age=36000, must-revalidate">
                                        </label>
                                    </p>
                                    <p class="description">Control the default cache control assigned by GCS.</p>
                                    <hr>

                                    <h4>Delete GCS File: </h4>
                                    <p>
                                        <select name="sm[delete_remote]" id="gcs_delete_file" ng-model="sm.delete_remote">
                                            <option value="true" selected="selected">Enable</option>
                                            <option value="false">Disable</option>
                                        </select>
                                    </p>
                                    <p class="description">Delete the GCS file when the file is deleted from WordPress.</p>
                                </fieldset>
                            </td>
                        </tr>  
                        <tr>
                            <th scope="row">File URL group</th>
                            <td>
                                <fieldset>
                                    <legend class="screen-reader-text"><span>File URL group</span></legend>
                                    <h4>Preview: </h4>
                                    <p>
                                        <label for="file_url_grp_preview">
                                            <input type="text" id="file_url_grp_preview" class="regular-text ltr" readonly="readonly" ng-model="sm.preview_url">
                                        </label>
                                    </p>
                                    <p class="description">An example file url utilizing all configured settings.</p>
                                    <hr>        

                                    <h4>Domain: </h4>
                                    <p>
                                        <label for="bucket_folder_name">
                                            <input name="sm[custom_domain]" ng-model="sm.custom_domain" type="text" id="bucket_folder_name" class="regular-text ltr" placeholder="storage.googleapis.com">
                                        </label>
                                    </p>
                                    <p class="description">Replace the default GCS domain with your own custom domain. This will require you to <a href="https://cloud.google.com/storage/docs/xml-api/reference-uris#cname" target="_blank">configure a CNAME</a>.</p>
                                    <hr>

                                    <h4>Organization: </h4>
                                    <p>
                                        <select id="org_url_grp" name="sm[organize_media]" ng-model="sm.organize_media">
                                            <option value="true" selected="selected">Enable</option>
                                            <option value="false">Disable</option>
                                        </select>
                                    </p>
                                    <p class="description">Organize uploads into year and month based folders.</p>

                                    <hr>
                                    <h4>Cache-Busting: </h4>
                                    <p>
                                        <select id="cache_busting" name="sm[hashify_file_name]" ng-model="sm.hashify_file_name">
                                            <option value="true" selected="selected">Enable</option>
                                            <option value="false">Disable</option>
                                        </select>
                                    </p>
                                    <p class="description">Prepends a random set of numbers and letters to the filename. This is useful for preventing caching issues when uploading files that have the same filename.</p>
                                </fieldset>
                            </td>
                        </tr> 
                        <tr>
                            <th scope="row">Thumbnails</th>
                            <td>
                                <fieldset>
                                    <legend class="screen-reader-text"><span>Thumbnails</span></legend>
                                    <p>
                                        <label for="file_url_grp_preview">
                                            <button class="button">Notify Me When Available!</button>
                                        </label>
                                    </p>
                                    <p class="description">Coming soon! Delegate thumbnail generation to the cloud and only when needed.</p>
                                </fieldset>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Synchronization</th>
                            <td>
                                <fieldset>
                                    <legend class="screen-reader-text"><span>Thumbnails</span></legend>
                                    <p class="description">Coming soon! Synchronize any amount of existing media across WordPress and GCS without the need of cron jobs or leaving your browser open.</p>
                                </fieldset>
                            </td>
                        </tr> 
                        <tr>
                            <th scope="row">Compression</th>
                            <td>
                                <fieldset>
                                    <legend class="screen-reader-text"><span>Thumbnails</span></legend>
                                    <p class="description">Coming soon! Optimize your image media with the perfect balance in quality and file size.</p>
                                </fieldset>
                            </td>
                        </tr>  
                    </tbody>
                </table>


                <?php submit_button(); ?> 
            </form> 
        </div>
        <div id="stless_sync_tab" class="stless_settings_content">
            <?php include 'regenerate_interface.php'; ?>
        </div>
        <div id="stless_supports_tab" class="stless_settings_content">
            
            <p>Keep your project moving forward and unhindered with access to our support team. With a support plan, you will have access to our support and engineering team to ask questions and receive assistance with your issues. You will also receive technical support, in-depth troubleshooting, and we’ll even log into your website to assist with resolving issues.</p>

            <div class="wpStateLess-support">

                <div class="wpStateLess-sprt-plan">
                    <div class="wpStateLess-plan-name">
                        <p>Yearly Access - $299</p>
                    </div>
                    <ul>
                        <li>access to our support and engineering teams.</li>
                        <li>setup assistance.</li>
                        <li>log into your site for troubleshooting.</li>
                        <li>in-depth technical assistance.</li>
                        <li>early access to thumbnail, synchronization, and compression features.</li>
                        <li>1-year coverage.</li>
                        <li>60% savings over 45-day support.</li>
                    </ul>
                </div>
                <div class="wpStateLess-sprt-plan">
                    <div class="wpStateLess-plan-name">
                        <p>45-Day Access - $99</p>
                    </div>
                    <ul>
                        <li>access to our support and engineering teams.</li>
                        <li>setup assistance.</li>
                        <li>log into your site for troubleshooting.</li>
                        <li>in-depth technical assistance.</li>
                        <li>45-day coverage.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>