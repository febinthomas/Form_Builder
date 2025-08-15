import { PlaceholderPattern } from '@/components/ui/placeholder-pattern';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm, usePage } from '@inertiajs/react';
import FormLayout from '@/layouts/form/layout';
import HeadingSmall from '@/components/heading-small';
import { Label } from "@/components/ui/label";
import { Input } from '@/components/ui/input';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'View',
        href: '/dashboard',
    },
];

export default function view({ formDetails }) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
                <div className="px-6 py-5">
                <div className="flex gap-8">
                    <div className="flex-1 max-w-xl">
                        <div className="space-y-6">
                            <HeadingSmall title={formDetails.title} />
                            {formDetails?.fields?.map((field, index) => (
                                <div key={index}>
                                    <Label htmlFor="background_color">{field.label}</Label>

                                    <Input
                                        className="mt-1 block w-full"
                                        autoComplete="background_color"
                                    />
                                </div>
                            ))}

                        </div>
                        <div>
            <div className="flex py-6">
              <Link
                href={route('form.list')}
                className="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
              >
                Back
  </Link>
            </div>                    </div>
                    </div>
                </div>
                </div>
        </AppLayout>
    );
}
