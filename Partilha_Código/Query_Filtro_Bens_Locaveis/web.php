##Adiciono rota no web:


Route::get('/disponiveis', [BensLocaveisController::class, 'all_avalible'])->name('disponiveis')->middleware([LimitDateMiddleware::class]);
