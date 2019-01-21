<?php
                        if (isset($tweet->extended_entities)) {
                            ?>
                            <div class="aptf-tweet-media">
                                <?php
                                if(count($tweet->extended_entities->media)>1){
                                    $image_size = 'thumb';
                                }
                                else
                                {
                                    $image_size = 'large';
                                }

                                //$this->print_array($tweet['extended_entities']);
                                foreach ($tweet->extended_entities->media as $media) {
                                    ?>
                                    <div class="aptf-each-media aptf-media-<?php echo $image_size; ?>">
                                        <a href="<?php echo $media->media_url ?>" data-lightbox="<?php echo $username;?>"><img src="<?php echo $media->media_url.':'.$image_size; ?>"/></a>
                                    </div>
                                    <?php
                                    //                $this->print_array($media);
                                }
                                ?>
                                </div>
                                <?php
                            }
                            ?>