<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head();
$has_permission_edit = has_permission('knowledge_base', '', 'edit');
$has_permission_create = has_permission('knowledge_base', '', 'create');
?>
<div id="wrapper">
   <div class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="panel_s mtop5">
               <div class="panel-body">
                  <div class="_buttons">
                     <?php if ($has_permission_create) { ?>
                        <a href="<?php echo admin_url('stripe_merchants/add'); ?>" class="btn btn-info mright5">New Stripe Merchant</a>
                     <?php } ?>
                  </div>
                  <hr class="hr-panel-heading" />
                  <div class="row">
                     <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="list_tab">
                           <div class="col-md-12">
                              <?php render_datatable(
                                 array(
                                    '#',
                                    'Publishable Key',
                                    'Active',
                                    'Status',
                                 ),
                                 'articles',
                                 [],
                                 [
                                    'data-last-order-identifier' => 'kb-articles',
                                    'data-default-order'         => get_table_last_order('kb-articles'),
                                 ]
                              ); ?>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php init_tail(); ?>
<script>
   $(function() {
      fix_kanban_height(290, 360);
      initKnowledgeBaseTableArticles();
      $(".groups").sortable({
         connectWith: ".article-group",
         helper: 'clone',
         appendTo: '#kan-ban',
         placeholder: "ui-state-highlight-kan-ban-kb",
         revert: true,
         scroll: true,
         scrollSensitivity: 50,
         scrollSpeed: 70,
         start: function(event, ui) {
            $('body').css('overflow', 'hidden');
         },
         stop: function(event, ui) {
            $('body').removeAttr('style');
         },
         update: function(event, ui) {
            if (this === ui.item.parent()[0]) {
               var articles = $(ui.item).parents('.article-group').find('li');
               i = 1;
               var order = [];
               $.each(articles, function() {
                  i++;
                  order.push([$(this).data('article-id'), i]);
               });
               setTimeout(function() {
                  $.post(admin_url + 'knowledge_base/update_kan_ban', {
                     order: order,
                     groupid: $(ui.item.parent()[0]).data('group-id')
                  });
               }, 100);
            }
         }
      }).disableSelection();

      $('.groups').sortable({
         cancel: '.sortable-disabled'
      });

      setTimeout(function() {
         $('.kb-kan-ban').removeClass('hide');
      }, 200);

      $(".container-fluid").sortable({
         helper: 'clone',
         item: '.kan-ban-col',
         cancel: '.sortable-disabled',
         update: function(event, ui) {
            var order = [];
            var status = $('.kan-ban-col');
            var i = 0;
            $.each(status, function() {
               order.push([$(this).data('col-group-id'), i]);
               i++;
            });
            var data = {}
            data.order = order;
            $.post(admin_url + 'knowledge_base/update_groups_order', data);
         }
      });
      // Status color change
      $('body').on('click', '.kb-kan-ban .cpicker', function() {
         var color = $(this).data('color');
         var group_id = $(this).parents('.panel-heading-bg').data('group-id');
         $.post(admin_url + 'knowledge_base/change_group_color', {
            color: color,
            group_id: group_id
         });
      });
      $('.toggle-articles-list').on('click', function() {
         var list_tab = $('#list_tab');
         if (list_tab.hasClass('active')) {
            list_tab.css('display', 'none').removeClass('active');
            $('.kan-ban-tab').css('display', 'block');
            fix_kanban_height(290, 360);
            mainWrapperHeightFix();
         } else {
            list_tab.css('display', 'block').addClass('active');
            $('.kan-ban-tab').css('display', 'none');
         }
      });
   });

   function initKnowledgeBaseTableArticles() {
      var KB_Articles_ServerParams = {};
      $.each($('._hidden_inputs._filters input'), function() {
         KB_Articles_ServerParams[$(this).attr('name')] = '[name="' + $(this).attr('name') + '"]';
      });
      $('._filter_data').toggleClass('hide');
      initDataTable('.table-articles', window.location.href, undefined, undefined, KB_Articles_ServerParams, [2, 'desc']);
   }
</script>
</body>

</html>