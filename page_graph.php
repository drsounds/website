<?php 
/** 
 * Template name: Graph
 */

get_header();?>
<div class="section section-default">
    <div class="section-content">
        <div class="row" style="padding-top: 75pt" style="padding: 0px">
            <div class="col-md-8" style="padding: 0px">
                <canvas id="viewport" width="1880" height="768"></canvas>
                <style type="text/css">
                .track {
                    background-color: #fff;
                    color: #222;
                    card-shadow: 0px 2px 12px rgba(0, 0, 0, .2);
                    border-radius:100%;
                    text-align: center;
                    padding-top: 22pt;
                    card-sizing: border-card  ;
                    font-size: 10pt;
                    margin-left: 10px;
                    position: absolute;
                }
                .film {
                }
                </style>
                <script type="text/javascript">
                    $.getJSON('/graph-api', function (data) {
                        jQuery('#viewport').attr('width', window.innerWidth);
                        jQuery('#viewport').attr('height', window.innerHeight - 70);
                        var sys = arbor.ParticleSystem(10);
                        sys.renderer = Renderer("#viewport") ;
                        var nodes = {};
                        jQuery.each(data.nodes, function (i, item) {
                        
                            nodes[item.id] = sys.addNode(item.id, {'color': item.color, 'shape' : 'dot', 'label': item.title});
                    
                        });
                        jQuery.each(data.links, function (i, link) {
                            sys.addEdge(nodes[link.from], nodes[link.to]);
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>
<?php get_footer();?>