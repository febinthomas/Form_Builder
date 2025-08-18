import { type BreadcrumbItem, type SharedData } from '@/types';
import { Transition } from '@headlessui/react';
import { Head, Link, useForm, usePage } from '@inertiajs/react';
import { FormEventHandler } from 'react';
import React, { useState } from "react";

import DeleteUser from '@/components/delete-user';
import HeadingSmall from '@/components/heading-small';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import {
    Select,
    SelectTrigger,
    SelectValue,
    SelectContent,
    SelectItem
} from "@/components/ui/select";
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/app-layout';
import FormLayout from '@/layouts/form/layout';
import { Separator } from '@/components/ui/separator';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'New Form',
        href: '/settings/profile',
    },
];

type ProfileForm = {
    name: string;
    email: string;
};

export default function CreateForm({ fieldTypes }: { fieldTypes: string[]}) {
    const { auth } = usePage<SharedData>().props;

    const { data, setData, post, errors, processing, recentlySuccessful } = useForm<Required<ProfileForm>>({
        title: '',
        is_label_enabled: 1,
        is_active: 1
    });


    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('form.store'), {
            preserveScroll: true,
        });
    };
    const addField: FormEventHandler = (e) => {

        e.preventDefault();
        if (data.fieldName && data.type) {
            setData(prev => ({
                ...prev,
                custom_form_fields: [
                    ...(prev.custom_form_fields || []),
                    {
                        form_field_type_id: data.type, 
                        label: data.fieldName, 
                        options: [
                            //{option:1,label:4},
                            //{option:3,label:5},
                        ]
                    }
                ]
            }));
        }

    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Form settings" />

            <FormLayout>
                <div className="flex gap-8">
                    <div className="flex-1 max-w-xl">
                        <div className="space-y-6">
                            <HeadingSmall title="Form information" description="Fill your form details" />

                            <form onSubmit={submit} className="space-y-6">
                                <div className="grid gap-2">
                                    <Label htmlFor="title">Title</Label>

                                    <Input
                                        id="title"
                                        className="mt-1 block w-full"
                                        //value={data.name}
                                        onChange={(e) => setData('title', e.target.value)}
                                        required
                                        autoComplete="title"
                                        placeholder="Title"
                                    />

                                    <InputError className="mt-2" message={errors.title} />
                                </div>

                                <div>
                                    <Label htmlFor="is_label_enabled"></Label>

                                    <Input
                                        id="is_label_enabled"
                                        className="mt-1 block w-full"
                                        value="1"
                                        onChange={(e) => setData('is_label_enabled', e.target.value)}
                                        required
                                        hidden
                                        autoComplete="is_label_enabled"
                                        placeholder="is_label_enabled"
                                    />

                                    <InputError className="mt-2" message={errors.title} />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="background_color">Background Color</Label>

                                    <Input
                                        id="background_color"
                                        className="mt-1 block w-full"
                                        value={data.background_color}
                                        onChange={(e) => setData('background_color', e.target.value)}
                                        required
                                        //type="color"
                                        autoComplete="background_color"
                                        placeholder="Background Color"
                                    />

                                    <InputError className="mt-2" message={errors.background_color} />
                                    <InputError className="mt-2" message={errors.custom_form_fields} />
                                    <div>
  <pre>{JSON.stringify(errors.custom_form_fields, null, 2)}</pre>
</div>

                                </div>

                                {data.custom_form_fields?.map((field, index) => (
                                    <div key={index}>
                                        <Label htmlFor="background_color">{field.label}</Label>

                                        <Input
                                            disabled
                                            className="mt-1 block w-full"
                                            autoComplete="background_color"
                                        />
                                    </div>
                                ))}
                                <div className="flex items-center gap-4">
                                    <Button disabled={processing}>Save Form</Button>

                                    <Transition
                                        show={recentlySuccessful}
                                        enter="transition ease-in-out"
                                        enterFrom="opacity-0"
                                        leave="transition ease-in-out"
                                        leaveTo="opacity-0"
                                    >
                                        <p className="text-sm text-neutral-600">Saved</p>
                                    </Transition>
                                    <InputError className="mt-2" message={errors.custom_form_fields} />

                                </div>
                            </form>
                        </div>
                    </div>
                    <div className="w-1/3 border-l border-gray-300 pl-8">
                        <HeadingSmall title="Form Fields" description="Add new Fields to the form" />


                        <div className="grid gap-2">
                            <br />
                            <Label htmlFor="fieldName">Field Label</Label>

                            <Input
                                id="fieldName"
                                className="mt-1 block w-full"
                                //value={data.fieldName}
                                onChange={(e) => data.fieldName = e.target.value}
                                required
                                autoComplete="fieldName"
                                placeholder="Field Label"
                            />

                            <InputError className="mt-2" message={errors.name} />
                        </div>

                        <br />
                        <div className="grid gap-2">
                            <Label htmlFor="role">Field Type</Label>

                            <Select
                                onValueChange={(value) => data.type = value}
                                defaultValue={data.type}
                            >
                                <SelectTrigger
                                    id="role"
                                    className="mt-1 block w-full h-10 px-3 text-sm rounded-md border border-input bg-background ring-offset-background focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 flex items-center justify-between"
                                >
                                    <SelectValue placeholder="Choose a type" />
                                </SelectTrigger>

                                <SelectContent>
                                    {fieldTypes?.map((type, idx) => (

                                        <SelectItem value={type.id}>{type.label}</SelectItem>
                                    ))}
                                </SelectContent>

                            </Select>
                            

                            <InputError className="mt-2" message={errors.role} />
                        </div>
                        <br />
                        <div className="flex items-center gap-4">
                            <Button disabled={processing} onClick={addField}>Add Field</Button>
                        </div>


                    </div>
                </div>
            </FormLayout>
        </AppLayout>
    );
}
