<?php

return [
    "validity" => 180,
    "max_radius" => 8,
    "max_days_for_new" => 7,
    "results_per_page" => 12,
    "communitywakefield_url" => env("COMMUNITYWAKEFIELD_URL", "communitywakefield.org"),
    "volunteerwakefield_url" => env("VOLUNTEERWAKEFIELD_URL", "volunteerwakefield.org"),

    "dashboard_url" => env("DASHBOARD_URL", "https://communitywakefield.org/dashboard"),

    "skills" => [
        "Creative",
        "Catering",
        "Decorating & carpentry",
        "Design",
        "IT / Computers",
        "Leadership",
        "Listening",
        "Maths/Numeracy",
        "Organising",
        "Photography",
        "Reading & writing",
        "Talking to others",
        "Teamwork",
    ],

    "requirements" => [
        "Criminal record check (DBS)",
        "Full driving license",
        "Live locally",
        "Access to a computer",
        "References",
    ],
];
