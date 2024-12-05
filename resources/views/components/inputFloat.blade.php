@props(['type'=>'text','name'=>'name','title'=>'title','value'=>null])
    <div class="form-floating">
        <input type="{{$type}}" class="form-control @error($name) is-invalid @enderror" wire:model="{{$name}}" name="{{$name}}"
         placeholder="..." value="{{old($name)?old($name):$value}}" id="{{$name}}">
        <label for="{{$name}}">{{ __($title)}} </label>
        @error($name)
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
