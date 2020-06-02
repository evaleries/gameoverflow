<?php 
if (session()->has('validation_errors')) {
    
    importView('sections.dashboard.alert', [
        'status' => 'danger', 
        'message' => implode('<br/>', array_values(array_map(function ($error) { return $error['message']; }, session()->flash('validation_errors'))))
    ]);
} elseif (session()->has('error')) {
    importView('sections.dashboard.alert', [
        'status' => 'danger', 
        'message' => session()->flash('error')
    ]);
}
?>
