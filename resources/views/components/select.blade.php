@props(['name'=>'name','title'=>'title'])
<div class="form-floating">
    <select class="form-select @error($name) is-invalid @enderror " name='{{$name}}' wire:model='{{$name}}'>
      <option value="Elegir" disabled>Elegir</option>
      {{$slot}}
    </select>
    <label for="floatingSelect">Seleccione un {{$title}}</label>
    @error($name)
        <span class="text-danger">{{$message}}</span>
    @enderror
  </div>
