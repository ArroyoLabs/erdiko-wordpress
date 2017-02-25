<?php echo $this->getView('post_header', $data) ?>
<article>
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1" id="post-body">
              <?php              
              if(isset($data->post_content))
                echo $data->post_content;
              ?>
            </div>
        </div>
    </div>
</article>

<?php if($data->post_type == 'post'): ?>
    
    <div class="container">
        <!-- Tag and category links -->
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1" id="taxonomy-links">
                <?php if(!empty($data->tags)): ?>
                    <p>Tags: <?php echo $this->getTagLinks($data) ?></p>
                <?php endif ?>
                <?php if(!empty($data->categories)): ?>
                    <p>Category: <?php echo $this->getCategoryLinks($data) ?></p>
                <?php endif ?>
            </div>
        </div>
        <!-- Embed comments -->
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
                <div id="disqus_thread"></div>
            </div>
        </div>
    </div>

    <script>
        /**
        * RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
        * LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables
        */
        
        /*
        var disqus_config = function () {
            this.page.url = 'http://local.johnarroyo.com/2010/07/issuu-and-uu/'; // Replace PAGE_URL with your page's canonical URL variable
            this.page.identifier = '481 http://www.johnarroyo.com/?p=481'; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
        }
        */
        
        (function() { // DON'T EDIT BELOW THIS LINE
        var d = document, s = d.createElement('script');

        s.src = '//johnarroyo.disqus.com/embed.js';

        s.setAttribute('data-timestamp', +new Date());
        (d.head || d.body).appendChild(s);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
    
<?php endif; ?>
