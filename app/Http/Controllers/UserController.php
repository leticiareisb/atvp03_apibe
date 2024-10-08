<?php

namespace App\Http\Controllers;
use App\Http\Requests\UserCreateRequest;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function index()
    {
        $user = User::select('id', 'name', 'email')->paginate('2');

        return [
            'status' => 200,
            'menssagem' => 'Usuários encontrados!!',
            'user' => $user
        ];
    }

    public function store(UserCreateRequest $request)
    {
        $data = $request->all();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        return [
            'status' => 200,
            'menssagem' => 'Usuário cadastrado com sucesso!!',
            'user' => $user
        ];
    }


    //Atualizar o usuário
    public function update(Request $request, $id)
    {
        //Validação de dados recebidos
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        ]);

        //Busca de usuário com ID
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado'], Response::HTTP_NOT_FOUND);
        }

        //Atualizar dados
        $user->update($validatedData);

        return response()->json(['message' => 'Usuário atualizado com sucesso', 'user' => $user], Response::HTTP_OK);
    }

    //Deletar o usuário
    public function destroy($id)
    {
        //Busca de usuário pelo ID
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado'], Response::HTTP_NOT_FOUND);
        }

        //Deleta o usuário
        $user->delete();

        return response()->json(['message' => 'Usuário deletado com sucesso'], Response::HTTP_OK);
    }
}
