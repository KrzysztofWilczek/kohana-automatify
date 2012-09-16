<a href="#" class="btn btn-success pull-left" rel="tooltip" title="Add a new user" data-placement="right"><i class="icon-plus icon-white"></i></a>
<?php echo View::factory('helpers/search');?>
<table class="table table-striped table-hover">
<col width="50"></col>
<col></col>
<col></col>
<col></col>
<col></col>
<col width="130"></col>
              <thead>
                <tr>
                  <th><?=$pagination->sortHeader('#', 'id');?></th>
                  <th><?=$pagination->sortHeader('First name', 'name');?></th>
                  <th>Last Name</th>
                  <th>Username</th>
                  <th>Flags</th>
                  <th>Manage</th>
                </tr>
              </thead>
              <tbody id="reloaded">
<?php echo View::factory('users/data_table')->set('items', $pagination->all());?>
              </tbody>
</table>
<?php echo View::factory('helpers/perpage');?>
<?php echo $pagination;?>