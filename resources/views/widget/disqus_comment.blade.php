<div class="widget widget-default">
    <div class="widget-header">
        <h6 id="comments_count"><i class="fa fa-comments fa-fw"></i>评论</h6>
    </div>
    <div class="widget-body">
        <section id="comments">
            <div id="disqus_thread"></div>
        </section>
        <script type="text/javascript">
            var disqus_shortname = XblogConfig.disqus_shortname;
            var disqus_url = '{{ $comment_url }}';
            var disqus_title = '{{ $comment_title }}';
            (function(){
                var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                dsq.src = 'https://go.disqus.com/embed.js';
                (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
            })();
        </script>
    </div>
</div>