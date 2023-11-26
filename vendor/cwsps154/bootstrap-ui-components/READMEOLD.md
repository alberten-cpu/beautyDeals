# bootstrap-ui-components
<a href="https://github.com/CWSPS154/bootstrap-ui-components/issues"><img alt="GitHub issues" src="https://img.shields.io/github/issues/CWSPS154/bootstrap-ui-components"></a>
<a href="https://github.com/CWSPS154/bootstrap-ui-components/stargazers"><img alt="GitHub stars" src="https://img.shields.io/github/stars/CWSPS154/bootstrap-ui-components"></a>
<a href="https://github.com/CWSPS154/bootstrap-ui-components"><img alt="GitHub license" src="https://img.shields.io/github/license/CWSPS154/bootstrap-ui-components"></a>

Help to build ui elements with bootstrap using laravel components
# Installation
Using Composer
```bash
composer require cwsps154/bootstrap-ui-components
```
### To publishing the package files
```bash
php artisan vendor:publish
```
You can use tag also
```bash
 php artisan vendor:publish --tag=config --tag=components
```
# Documentation
### Components available
- `form`
- `input`
- `textarea`
- `select` - supporting `select2`
- `radio`
- `checkbox`
- `file`
- `button`
### Usage
You can use these components with the namespace `x-buicomponents`
- `x-buicomponents::ui.form`

        <x-buicomponents::ui.form method="POST" action="{{ route('test') }}">````````</x-buicomponents::ui.form>
- `x-buicomponents::ui.input`

      <x-buicomponents::ui.input type="text" name="test" label="Test" placeholder="Please Enter" data-id="taa" required>Sanoop</x-buicomponents::ui.input>
- `x-buicomponents::ui.textarea`

      <x-buicomponents::ui.button name="save" color="primary" class="test" data-id="test">Save</x-buicomponents::ui.button>
- `x-buicomponents::ui.select`

      <x-buicomponents::ui.select label="Street Area" name="area_id" id="area_id" required :options="['test'=>'fff']" class="area" value="test"></x-buicomponents::ui.select>
- `x-buicomponents::ui.radio`

      <x-buicomponents::ui.radio name="checkbox" id="test1" value="1" required>Check me out</x-buicomponents::ui.radio>
- `x-buicomponents::ui.checkbox`

      <x-buicomponents::ui.checkbox name="checkbox" id="testc" value="1" required>Check me out</x-buicomponents::ui.checkbox>
- `x-buicomponents::ui.file`

      <x-buicomponents::ui.file name="test" label="Test" data-id="taa" required></x-buicomponents::ui.file>
- `x-buicomponents::ui.button`

      <x-buicomponents::ui.button name="save" color="primary" class="test" data-id="test">Save</x-buicomponents::ui.button>

### Select2
You can enable/disable select2 and change its cdn link from config `buicomponents.php`
- In Controller
    ```
  public function getAreas()
    {
        if (\request()->ajax()) {
            $search = request()->search;
            $id = request()->id;
            $areas = Area::select('id', 'area')->when(
                $search,
                function ($query) use ($search) {
                    $query->where('area', 'like', '%' . $search . '%');
                }
            )->when($id, function ($query) use ($id) {
                $query->where('id', $id);
            })->limit(15)->get();
            $response = array();
            foreach ($areas as $area) {
                $response[] = array(
                    "id" => $area->id,
                    "text" => $area->area
                );
            }
            return response()->json($response);
        }
    }
- `In Blade`

      <x-buicomponents::ui.select label="Area" name="area" id="area" required options="area.list" class="area"/>

### Example
    <x-buicomponents::ui.form method="POST" action="{{ route('test') }}">
        <x-buicomponents::ui.input type="text" name="test" label="Test" placeholder="Please Enter" data-id="taa" required>Sanoop</x-buicomponents::ui.input>
        <x-buicomponents::ui.checkbox name="checkbox" id="testc" value="1" required>Check me out</x-buicomponents::ui.checkbox>
        <x-buicomponents::ui.radio name="checkbox" id="test1" value="1" required>Check me out</x-buicomponents::ui.radio>
        <x-buicomponents::ui.radio name="checkbox" id="test3" value="1" required>Check me out</x-buicomponents::ui.radio>
        <x-buicomponents::ui.select label="Street Area" name="area_id" id="area_id" required :options="['test'=>'fff']" class="area" value="test"></x-buicomponents::ui.select>
        <x-buicomponents::ui.textarea name="textarea" required label="Textarea">Check me out</x-buicomponents::ui.textarea>
        <x-buicomponents::ui.file name="test" label="Test" data-id="taa" required></x-buicomponents::ui.file>
        <x-buicomponents::ui.button name="save" color="primary" class="test" data-id="test">Save</x-buicomponents::ui.button>
    </x-buicomponents::ui.form>

## Author

- Github [@CWSPS154](https://www.github.com/CWSPS154)
- Gmail [@codewithsps154@gmail.com](mailto:codewithsps154@gmail.com)
## License

[MIT](https://choosealicense.com/licenses/mit/)
