
<script>
    $(".delete").on("submit", function(){
        return confirm("Do you want to delete this item?");
    });
</script>

<td>

<a href="{{route('deleteattendentstudent.delete',$entry->created_at)}}" class="btn btn-xs btn-default" data-button-type="delete"><i class="fa fa-trash"></i> Delete</a>
</td>

