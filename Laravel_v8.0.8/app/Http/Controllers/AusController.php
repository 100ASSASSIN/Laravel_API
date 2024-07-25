<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class AusController extends Controller
{
    public function Bot()
    {
        $data = DB::select('SELECT * FROM employee');
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i:s',
            'active_status' => 'required|boolean',
        ]);
        DB::update('UPDATE employee SET name = ?, date = ?, time = ?, active_status = ? WHERE id = ?', [
            $validatedData['name'],
            $validatedData['date'],
            $validatedData['time'],
            $validatedData['active_status'],
            $id
        ]);

        return response()->json(['message' => 'Employee updated successfully']);
    }
    public function insert(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|int|max:10',
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i:s',
            'active_status' => 'required|boolean',
        ]);

        DB::insert('INSERT INTO employee (id, name, date, time, active_status) VALUES (?, ?, ?, ?, ?)', [
            $validatedData['id'],
            $validatedData['name'],
            $validatedData['date'],
            $validatedData['time'],
            $validatedData['active_status']
        ]);

        return response()->json(['message' => 'Employee inserted successfully']);
    }


    public function tab()
    {
        $data = DB::select('SELECT * FROM assassin');
        return response()->json($data);
    }

    public function add()
    {
        DB::statement('CREATE TABLE IF NOT EXISTS assassin (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            date DATE NOT NULL,
            time TIME NOT NULL,
            active_status BOOLEAN NOT NULL
        )');

        return response()->json(['message' => 'TABLE CREATED SUCCESSFULLY']);
    }

    public function values(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $inserted = DB::insert('INSERT INTO assassin (name) VALUES (?)', [
            $validatedData['name'],
        ]);
        if ($inserted) {
            return response()->json(['message' => 'Value added successfully'], 201);
        } else {
            return response()->json(['message' => 'Failed to add value'], 500);
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i:s',
            'active_status' => 'required|boolean',
        ]);

        $inserted = DB::insert('INSERT INTO employee (name, date, time, active_status) VALUES (?, ?, ?, ?)', [
            $validatedData['name'],
            $validatedData['date'],
            $validatedData['time'],
            $validatedData['active_status'],
        ]);

        if ($inserted) {
            return response()->json(['message' => 'Employee added successfully'], 201);
        } else {
            return response()->json(['message' => 'Failed to add employee'], 500);
        }
    }
    public function delete($name)
    {
        if (empty($name)) {
            return response()->json(['message' => 'Invalid name'], 400);
        }

        $deleted = DB::table('employee')->where('name', $name)->delete();

        if ($deleted) {
            return response()->json(['message' => 'Employee deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Employee not found'], 404);
        }
    }

    public function up(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i:s',
            'active_status' => 'required|boolean',
        ]);

        $exists = DB::table('employee')->where('name', $validatedData['name'])->exists();

        if ($exists) {
            return response()->json(['error' => 'An employee with this name already exists.'], 409);
        }

        DB::table('employee')->insert([
            'name' => $validatedData['name'],
            'date' => $validatedData['date'],
            'time' => $validatedData['time'],
            'active_status' => $validatedData['active_status'],
        ]);

        return response()->json(['message' => 'Employee added successfully']);
    }

    public function up2(Request $request)
{
    try {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i:s',
            'active_status' => 'required|boolean',
        ]);
        $exists = DB::table('employee')->where('name', $validatedData['name'])->exists();

        if ($exists) {
            return response()->json(['error' => 'An employee with this name already exists.'], 409);
        }
        DB::table('employee')->insert([
            'name' => $validatedData['name'],
            'date' => $validatedData['date'],
            'time' => $validatedData['time'],
            'active_status' => $validatedData['active_status'],
        ]);
        return response()->json(['message' => 'Employee added successfully']);

    } catch (ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);
    }
}

}
