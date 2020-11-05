<!-- Select template field. Used in Backpack/PageManager to redirect to a form with different fields if the template changes. A fork of the select_from_array field with an extra ID and an extra javascript file. -->
@php
    $item_name = strtolower(isset($field['entity_singular']) && !empty($field['entity_singular']) ? $field['entity_singular'] : $field['label']);
    $field['options'] = $crud->getCurrentEntry()->items;
    if (!isset($field['options'])) {
        $options = $field['model']::all();
    } else {
        $options = $field['options'];
    }
    // dd($options);
@endphp

  <div @include('crud::inc.field_wrapper_attributes') >

    <label>{{ $field['label'] }}</label>
    <div class="array-container form-group">

        <table class="table table-bordered table-striped m-b-0" >

            <thead>
                <tr>

                    @foreach( $field['columns'] as $prop )
                    <th style="font-weight: 600!important;">
                        {{ $prop }}
                    </th>
                    @endforeach
                </tr>
            </thead>

            <tbody ui-sortable="sortableOptions" ng-model="items" class="table-striped">

                @foreach ($options as $option)
                <tr ng-repeat="item in items" class="array-row">

                    @foreach( $field['columns'] as $prop)
                    <td>
                        {{ $option->{$prop} }}
                    </td>
                    @endforeach
                </tr>
                @endforeach

            </tbody>

        </table>
    </div>
  </div>

{{-- ########################################## --}}